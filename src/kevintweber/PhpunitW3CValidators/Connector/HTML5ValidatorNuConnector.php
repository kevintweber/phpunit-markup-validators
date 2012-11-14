<?php

namespace kevintweber\PhpunitW3CValidators\Connector;

use kevintweber\PhpunitW3CValidators\Connector\HTMLConnector;

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