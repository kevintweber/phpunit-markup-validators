<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kevintweber\PhpunitMarkupValidators\Connector;

use kevintweber\PhpunitMarkupValidators\Connector\Connector;

/**
 * A base class from HTML connectors
 */
abstract class HTMLConnector extends Connector
{
    /**
     * Ensure that HTML fragments are submitted as complete webpages.
     *
     * @param string $value The HTML markup, either a fragment or a complete webpage.
     */
    public function setHtmlInput($value)
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