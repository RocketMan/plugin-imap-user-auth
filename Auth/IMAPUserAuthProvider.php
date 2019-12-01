<?php
/**
 * IMAP User Authentication Plugin for Kanboard
 *
 * @author Jim Mason <jmason@ibinx.com>
 * @copyright Copyright (C) 2019 Jim Mason <jmason@ibinx.com>
 * @link https://github.com/RocketMan/plugin-imap-user-auth
 * @license MIT
 */

namespace Kanboard\Plugin\IMAPUserAuth\Auth;

use Kanboard\Core\Security\PasswordAuthenticationProviderInterface;
use Kanboard\Core\User\UserProviderInterface;
use Kanboard\Model\UserModel;
use Kanboard\User\DatabaseUserProvider;

class IMAPUserAuthProvider implements PasswordAuthenticationProviderInterface {
    protected $userinfo;
    protected $username;
    protected $password;

    protected $mailbox;
    protected $domain;
    protected $plugin;

    const DEFAULT_MAILBOX='{%DOMAIN%:993/imap/ssl/novalidate-cert/notls}';

    public function __construct($plugin) {
        $this->mailbox = $plugin->configModel->get('plugin_imap_user_auth_mailbox', '');
        $this->domain = $plugin->configModel->get('plugin_imap_user_auth_domain', '');

        $this->plugin = $plugin;
    }

    public function getUser() {
        if(empty($this->userinfo))
            return null;

        return new DatabaseUserProvider($this->userinfo);
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getName() {
        return 'IMAPUserAuth';
    }

    public function authenticate() {
        $mailbox = $this->mailbox;
        if(empty($mailbox) && !empty($this->domain))
            $mailbox = str_replace('%DOMAIN%', $this->domain, self::DEFAULT_MAILBOX);

        if(!function_exists('imap_open')) {
            $this->plugin->raiseException([
                t("The PHP IMAP module is missing."),
                t("See the [Documentation]({PluginHomepage}) for setup instructions.")
            ]);
        } else if(empty($mailbox)) {
            $this->plugin->raiseException([
                t("The plugin's configuration settings are missing."),
                t("See the [Documentation]({PluginHomepage}) for setup instructions.")
            ]);
        }

        // supply curly braces if not already present
        if(strpos('x' . trim($mailbox), '{', 1) != 1)
            $mailbox = '{' . $mailbox . '}';

        $username = $this->username;
        if(!empty($this->domain)) {
            $pieces = explode('@', $this->username);
            if(count($pieces) == 1)
                $username = $this->username . '@' . $this->domain;
            else if(count($pieces) == 2 && $pieces[1] == $this->domain)
                $this->username = $pieces[0];
        }

        // lookup user in the local database
        $user = $this->plugin->db
            ->table(UserModel::TABLE)
            ->columns('id')
            ->eq('username', $this->username)
            ->eq('disable_login_form', 0)
            ->eq('is_ldap_user', 1)
            ->eq('is_active', 1)
            ->findOne();

        // if user does not exist, no point in going further
        if(empty($user))
            return false;

        // validate user's credentials via IMAP
        $mbox = @imap_open($mailbox, $username, $this->password, OP_HALFOPEN, 1);

        if($mbox !== FALSE) {
            // success!
            imap_close($mbox);
            $this->userinfo = $user;
            return true;
        }

        return false;
    }
}
