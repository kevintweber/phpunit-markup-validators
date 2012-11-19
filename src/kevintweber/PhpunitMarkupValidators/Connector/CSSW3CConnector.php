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
use kevintweber\PhpunitMarkupValidators\ResponseParser\W3CResponseParser;

class CSSW3CConnector extends CSSConnector
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setOutputType("soap12");
        $this->setUrl("http://jigsaw.w3.org/css-validator/validator");
    }

    protected function getMarkupOpts()
    {
        return array(CURLOPT_URL        => $this->getUrl(),
                     CURLOPT_POSTFIELDS => array(
                         'output' => $this->getOutputType(),
                         'profile' => 'css3',
                         'text' => $this->getInput()
                         ));
    }

    protected function getFileOpts()
    {
        return array(CURLOPT_URL        => $this->getUrl(),
                     CURLOPT_POSTFIELDS => array(
                         'output' => $this->getOutputType(),
                         'profile' => 'css3',
                         'text' => $this->getInput()
                         ));
    }

    protected function getUrlOpts()
    {
        return array(CURLOPT_URL => $this->getUrl() . "?profile=css3&output=" .
                     urlencode($this->getOutputType()) . "&uri=" .
                     urlencode($this->getInput()));
    }

    /**
     * Parses the SOAP 1.2 response.
     *
     * @param string $response The SOAP 1.2 response.
     *
     * @return bool True if the response found valid.
     */
    public function processResponse($response)
    {
        try {
            $dom = new \DOMDocument();
            $dom->strictErrorChecking = false;

            if ($dom->loadXML($response)) {
                $validityElement = $dom->getElementsByTagName('validity');
                if ($validityElement->length && $validityElement->item(0)->nodeValue == 'true') {
                    return true;
                }
            }
        }
        catch (\Exception $e) {
            throw new \PHPUnit_Framework_Exception($e->getMessage());
        }

        return false;
    }

    /**
     * Will parse the SOAP response and display the failure reasons.
     *
     * @param string $response The SOAP 1.2 response text.
     *
     * @return string A description of the failure.
     */
    public function describeFailure($response)
    {
        $responseArray = array();

        // Parse response.
        try {
            $dom = new \DOMDocument();
            $dom->strictErrorChecking = false;

            if ($dom->loadXML($response)) {
                // Parse errors.
                $errors = $dom->getElementsByTagName('error');
                foreach ($errors as $error) {
                    $responseArray[] = new W3CResponseParser('Error', $error);
                }

                // Parse warnings.
                $warnings = $dom->getElementsByTagName('warning');
                foreach ($warnings as $warning) {
                    $responseArray[] = new W3CResponseParser('Warning', $warning);
                }
            }
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        // Format response text.
        $result = '';

        foreach ($responseArray as $problem) {
            $result .= $problem . "\n";
        }

        return $result;
    }
}