<?php

namespace Seo;

use Pimcore\API\Plugin as PluginLib;

use Seo\Plugin\Install;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    /**
     * @var \Zend_Translate
     */
    protected static $_translate;

    /**
     * Plugin constructor.
     *
     * @param null $jsPaths
     * @param null $cssPaths
     * @param null $alternateIndexDir
     */
    public function __construct($jsPaths = NULL, $cssPaths = NULL, $alternateIndexDir = NULL)
    {
        parent::__construct($jsPaths, $cssPaths);

        define('SEO_PATH', PIMCORE_PLUGINS_PATH . '/Seo');
        define('SEO_INSTALL_PATH', SEO_PATH . '/install');
    }

    /**
     * @param $e
     */
    public function preDispatch($e)
    {

        $e->getTarget()->registerPlugin(new Controller\Plugin\Frontend());
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return mixed
     */
    public static function install()
    {
        $install = new Install();
        $install->createConfig();
        $install->installAdminTranslations();

        return self::getTranslate()->_('seo_installed_successfully');
    }

    /**
     * @return mixed
     */
    public static function uninstall()
    {
        try {
            $install = new Install();
            $install->removeConfig();

            return self::getTranslate()->_('seo_uninstalled_successfully');
        } catch (\Exception $e) {
            \Pimcore\Logger::crit($e);

            return self::getTranslate()->_('seo_uninstall_failed');
        }
    }

    /**
     * @return bool
     */
    public static function isInstalled()
    {
        $install = new Install();

        return $install->isInstalled();
    }

    /**
     * @return string
     */
    public static function getTranslationFileDirectory()
    {
        return SEO_PATH . '/lang';
    }

    /**
     * @param string $language
     *
     * @return string path to the translation file relative to plugin directory
     */
    public static function getTranslationFile($language)
    {
        if (is_file(PIMCORE_PLUGINS_PATH . '/Seo/static/texts/' . $language . '.csv')) {
            return '/Seo/static/texts/' . $language . '.csv';
        } else {
            return '/Seo/static/texts/en.csv';
        }
    }

    /**
     * @return \Zend_Translate
     */
    public static function getTranslate()
    {
        if (self::$_translate instanceof \Zend_Translate) {
            return self::$_translate;
        }

        try {
            $lang = \Zend_Registry::get('Zend_Locale')->getLanguage();
        } catch (\Exception $e) {
            $lang = 'en';
        }

        self::$_translate = new \Zend_Translate('csv', PIMCORE_PLUGINS_PATH . self::getTranslationFile($lang), $lang, ['delimiter' => ',']);

        return self::$_translate;
    }
}
