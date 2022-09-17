<?php

namespace Ebay;

// Configuration class to handle settings

class eBaySession
{
    private $_properties;

    public function __construct($dev, $app, $cert)
    {
        $this->_properties = [
            'dev'     => null,
            'app'     => null,
            'cert'    => null,
            'wsdl'    => null,
            'options' => null,
            'token'   => null,
            'site'    => null,
            'location'=> null,
        ];

        $this->dev = $dev;
        $this->app = $app;
        $this->cert = $cert;

        $test = @get_headers('https://developer.ebay.com/webservices/1255/ebaysvc.wsdl');
        if (isset($test[0]) && strpos($test[0], 'Not Found') !== false) {
          $this->wsdl = 'https://developer.ebay.com/webservices/1255/ebaysvc.wsdl';
        } else {
          $this->wsdl = 'https://developer.ebay.com/webservices/1255/ebaysvc.wsdl';
        }

        $this->options = [
                            'trace' => 1,
                            'exceptions' => 0,
                            'classmap' => [
                                            /* 'UserType' => 'eBayUserType', */
                                            'GetSearchResultsResponseType' => 'eBayGetSearchResultsResponseType',
                                            'SearchResultItemArrayType' => 'eBaySearchResultItemArrayType',
                                            'SearchResultItemType' => 'eBaySearchResultItemType',
                                            //'AmountType' => 'eBayAmountType',
                                            //'FeeType' => 'eBayFeeType',
                                            //'FeesType' => 'eBayFeesType',
                                        ],
                           /* 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP, */
                      ];
    }

    public function __set($property, $value)
    {
        if (array_key_exists($property, $this->_properties)) {
            $this->_properties[$property] = $value;
        } else {
            return;
        }
    }

    public function __get($property)
    {
        if (array_key_exists($property, $this->_properties)) {
            return $this->_properties[$property];
        } else {
            return;
        }
    }
}
