<?php

namespace Seo\Plugin;

use Seo\Model\Configuration;

use Pimcore\Model\Object;
use Pimcore\Model\Object\Folder;
use Pimcore\Model\Staticroute;
use Pimcore\Model\Translation\Admin;
use Pimcore\Model\User;
use Pimcore\Tool;

class Install {

    public function isInstalled()
    {
        $configFile = \Pimcore\Config::locateConfigFile('seo_configurations');

        if (is_file($configFile . '.php'))
        {
            $isInstalled = Configuration::get('seo_is_installed');

            if ($isInstalled)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function createConfig()
    {
        $configFile = \Pimcore\Config::locateConfigFile('seo_configurations');

        if (is_file($configFile . '.BACKUP'))
        {
            rename($configFile . '.BACKUP', $configFile . '.php');
            return TRUE;
        }

        Configuration::set('jsonld_generator', [
            'fixedProperties' => []
        ]);

        Configuration::set('seo_is_installed', TRUE);

        return TRUE;

    }

    public function removeConfig()
    {
        $configFile = \Pimcore\Config::locateConfigFile('seo_configurations');

        if (is_file($configFile . '.php'))
        {
            rename($configFile . '.php', $configFile . '.BACKUP');
        }
    }

    public function installAdminTranslations()
    {
        $csv = SEO_INSTALL_PATH . '/translations/data.csv';
        Admin::importTranslationsFromFile($csv, true, \Pimcore\Tool\Admin::getLanguages());
    }


}
