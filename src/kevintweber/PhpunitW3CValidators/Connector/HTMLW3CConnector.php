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
        $this->setOutputType("text");
        $this->setUrl("http://validator.w3.org/");
    }

    protected function getPostVariables()
    {
        return array(
            'output' => $this->getOutputType(),
            'uploaded_file' => $this->getInput()
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