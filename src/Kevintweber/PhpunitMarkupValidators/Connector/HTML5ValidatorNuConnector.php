<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kevintweber\PhpunitMarkupValidators\Connector;


class HTML5ValidatorNuConnector extends Connector
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setOutputType("text");
        $this->setUrl("https://html5.validator.nu/");
    }

    protected function getMarkupOpts()
    {
        return array(
            CURLOPT_URL        => $this->getUrl(),
            CURLOPT_POSTFIELDS => array(
                'out' => $this->getOutputType(),
                'content' => $this->getInput(),
            )
        );
    }

    protected function getFileOpts()
    {
        return array(
            CURLOPT_URL        => $this->getUrl(),
            CURLOPT_POSTFIELDS => array(
                'out' => $this->getOutputType(),
                'content' => $this->getInput(),
            )
        );
    }

    protected function getUrlOpts()
    {
        return array(
            CURLOPT_URL => $this->getUrl()."?out=".
            urlencode($this->getOutputType())."&doc=".
            urlencode($this->getInput())
        );
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

    /**
     * Ensure that HTML fragments are submitted as complete webpages.
     *
     * @param string $value The HTML markup, either a fragment or a complete webpage.
     */
    public function setInput($value)
    {
        if (stripos($value, 'html>') === false) {
            $this->input = '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>Title</title></head><body>'.
                $value.'</body></html>';
        } else {
            $this->input = $value;
        }
    }
}
