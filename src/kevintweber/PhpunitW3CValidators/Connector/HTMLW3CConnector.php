<?php

namespace kevintweber\PhpunitW3CValidators\Connector;

use kevintweber\PhpunitW3CValidators\Connector\HTMLConnector;

class HTMLW3CConnector extends HTMLConnector
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setOutputType("soap12");
        $this->setUrl("http://validator.w3.org/check");
    }

    protected function getPostVariables()
    {
        return array(
            'output' => $this->getOutputType(),
            'uploaded_file' => $this->getInput()
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