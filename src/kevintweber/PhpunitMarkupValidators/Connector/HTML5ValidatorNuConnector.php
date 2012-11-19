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

use kevintweber\PhpunitMarkupValidators\Connector\HTMLConnector;

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

    protected function getMarkupOpts()
    {
        return array(CURLOPT_URL        => $this->getUrl(),
                     CURLOPT_POSTFIELDS => array(
                         'out' => $this->getOutputType(),
                         'content' => $this->getInput()
                         ));
    }

    protected function getFileOpts()
    {
        return array(CURLOPT_URL        => $this->getUrl(),
                     CURLOPT_POSTFIELDS => array(
                         'out' => $this->getOutputType(),
                         'content' => $this->getInput()
                         ));
    }

    protected function getUrlOpts()
    {
        return array(CURLOPT_URL => $this->getUrl() . "?out=" .
                     urlencode($this->getOutputType()) . "&doc=" .
                     urlencode($this->getInput()));
    }

    /**
     * @return bool True if the response is valid.
     */
    public function processResponse($result)
    {
        if (stripos($result, 'is valid HTML') !== false) {
            return true;
        }

        return false;
    }
}