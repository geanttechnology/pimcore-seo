<?php

namespace Seo\Tool;

use Seo\Model\Configuration;

class JsonLD
{
    /**
     * @param object $input
     * @param array  $additionalProperties
     *
     * @return mixed
     */
    public static function get($input, $additionalProperties = [])
    {
        if (is_object($input) && method_exists($input, 'getJsonLDData')) {

            $config = Configuration::get('jsonld_generator');

            $data = array_merge(
                $input->getJsonLDData(),
                is_array($config['fixedProperties']) ? $config['fixedProperties'] : [],
                $additionalProperties
            );

            return $data;
        }
    }

}