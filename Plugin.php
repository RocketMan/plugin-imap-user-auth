<?php
/**
 * IMAP User Authentication Plugin for Kanboard
 *
 * @author Jim Mason <jmason@ibinx.com>
 * @copyright Copyright (C) 2019 Jim Mason <jmason@ibinx.com>
 * @link https://github.com/RocketMan/plugin-imap-user-auth
 * @license MIT
 */

namespace Kanboard\Plugin\IMAPUserAuth;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\IMAPUserAuth\Auth\IMAPUserAuthProvider;

class Plugin extends Base
{
    public function initialize()
    {
        $this->authenticationManager->register(
            new IMAPUserAuthProvider($this->configModel, $this->db));
        $this->template->hook->attach('template:config:integrations',
            'IMAPUserAuth:config');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'IMAP User Authentication';
    }

    public function getPluginDescription()
    {
        return t('Login to Kanboard using your IMAP credentials');
    }

    public function getPluginAuthor()
    {
        return 'Jim Mason';
    }

    public function getPluginVersion()
    {
        return '1.0.2';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/RocketMan/plugin-imap-user-auth';
    }
}

