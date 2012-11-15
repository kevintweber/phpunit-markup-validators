<?php

namespace kevintweber\PhpunitW3CValidators\Connector;

use kevintweber\PhpunitW3CValidators\Connector\Connector;

class CSSW3CConnector extends Connector
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setOutputType("soap12");
        $this->setUrl("http://jigsaw.w3.org/css-validator/validator");
    }

    protected function getPostVariables()
    {
        return array(
            'output' => $this->getOutputType(),
            'profile' => 'css3',
            'text' => $this->getInput()
            );
    }

    /**
     * Parses the SOAP 1.2 response.
     *
     * @todo Need to parse warnings and errors.
     *
     * @param string $result The SOAP 1.2 response.
     */
    public function processResult($result)
    {
        $dom = new \DOMDocument();
        if ($dom->loadXML($result)) {
            $validityElement = $dom->getElementsByTagName('validity');
            if ($validityElement->length && $validityElement->item(0)->nodeValue == 'true') {
                return true;
            }
        }

        return false;
    }
}