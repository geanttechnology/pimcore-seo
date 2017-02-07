<?php

namespace Seo\Helper\View;

use Seo\Tool\JsonLD;

class SeoHelper extends \Zend_View_Helper_Abstract
{
    /**
     * @return $this
     */
    public function seoHelper()
    {
        return $this;
    }

    /**
     * @param object $input
     * @param array  $additionalProperties
     *
     * @return mixed
     */
    public function getJsonLD($input, $additionalProperties = [])
    {
        return $this->view->partial('/helper/jsonld.php', ['data' => JsonLD::get($input, $additionalProperties)]);
    }

}