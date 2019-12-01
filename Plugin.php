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
            new IMAPUserAuthProvider($this));
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
        return '1.0.3';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/RocketMan/plugin-imap-user-auth';
    }

    /**
     * replace all instances of {PluginXXX} with the results of the
     * evaluation $this->getPluginXXX()
     */
    public function resolveMetadata($text)
    {
        return preg_replace_callback('/\{Plugin(.*?)\}/', function($matched) {
            return call_user_func([$this, "getPlugin".$matched[1]]); }, $text);
    }

    /**
     * resolve all metadata and Markdown hyperlinks in the supplied text
     */
    public function resolveMarkdown($text)
    {
        return preg_replace('/\[(.*?)\]\((.*?)\)/', "<A HREF='$2'>$1</A>",
            $this->resolveMetadata($text));
    }

    public function raiseException($messages)
    {
        $output = "";
        foreach($messages as $message)
            $output .= "<P>".$this->resolveMarkdown($message)."</P>";

        throw new \LogicException($output);
    }
}

