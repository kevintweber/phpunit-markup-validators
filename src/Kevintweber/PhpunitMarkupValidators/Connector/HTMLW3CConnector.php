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

use Kevintweber\PhpunitMarkupValidators\ResponseParser\W3CResponseParser;

class HTMLW3CConnector extends HTMLConnector
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setOutputType("soap12");
        $this->setUrl("http://validator.w3.org/check");
    }

    protected function getMarkupOpts()
    {
        return array(
            CURLOPT_URL => $this->getUrl(),
            CURLOPT_POSTFIELDS => array(
                'output' => $this->getOutputType(),
                'uploaded_file' => $this->getInput()
            )
        );
    }

    protected function getFileOpts()
    {
        return array(
            CURLOPT_URL => $this->getUrl(),
            CURLOPT_POSTFIELDS => array(
                'output' => $this->getOutputType(),
                'uploaded_file' => $this->getInput()
            )
        );
    }

    protected function getUrlOpts()
    {
        return array(
            CURLOPT_URL => $this->getUrl()."?output=".
            urlencode($this->getOutputType())."&uri=".
            urlencode($this->getInput())
        );
    }

    /**
     * Parses the SOAP 1.2 response.
     *
     * @param string $result The SOAP 1.2 response.
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
        } catch (\Exception $e) {
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
                    $this->responseArray[] = new W3CResponseParser('Error', $error);
                }

                // Parse warnings.
                $warnings = $dom->getElementsByTagName('warning');
                foreach ($warnings as $warning) {
                    $this->responseArray[] = new W3CResponseParser('Warning', $warning);
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        // Format response text.
        $result = '';

        foreach ($this->responseArray as $problem) {
            $result .= $problem."\n";
        }

        return $result;
    }
}
