<?php

namespace Seo\Controller\Plugin;

class Frontend extends \Zend_Controller_Plugin_Abstract {

    public function preDispatch(\Zend_Controller_Request_Abstract $request) {

        parent::preDispatch($request);

        /** @var \Pimcore\Controller\Action\Helper\ViewRenderer $renderer */
        $renderer = \Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer');
        $renderer->initView();

        /** @var \Pimcore\View $view */
        $view = $renderer->view;

        $view->addScriptPath(PIMCORE_PLUGINS_PATH . '/Seo/views/scripts');
        $view->addHelperPath(PIMCORE_PLUGINS_PATH . '/Seo/lib/Seo/Helper/View', 'Seo\Helper\View');

    }

}
