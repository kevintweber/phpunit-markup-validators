<?php

namespace kevintweber\PhpunitW3CValidators\Connector;

use kevintweber\PhpunitW3CValidators\Connector\Connector;

/**
 * A helper class from HTML connectors
 */
abstract class HTMLConnector extends Connector
{
    /**
     * Override the input setter to ensure that HTML fragments are submitted as complete webpages.
     *
     * @param string $value The HTML markup, either a fragment or a complete webpage.
     */
    public function setInput($value)
    {
        if (stripos($value, 'html>') === false) {
            $this->input = '<!DOCTYPE html><html><head><meta charset="utf-8" /><title></title></head><body>' .
                $value . '</body></html>';
        }
        else {
            $this->input = $value;
        }

    }
}