<?php

namespace kevintweber\phpunit-w3c-validators\Connector;

use kevintweber\phpunit-w3c-validators\Connector\HTMLConnector;

class HTML5ValidatorNuConnector extends HTMLConnector
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setOutputType("text");
        $this->setUrl("http://html5.validator.nu/");
    }

    protected function getPostVariables()
    {
        return array(
            'out' => $this->getOutputType(),
            'content' => $this->getInput()
            );
    }

    public function processResult($result)
    {
        if (stripos($result, 'Error') !== false || stripos($result, 'Warning') !== false) {
            return false;
        }

        return true;
    }
}