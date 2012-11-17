<?php

/*
 * This file is part of the PhpunitW3CValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kevintweber\PhpunitW3CValidators\Connector;

use kevintweber\PhpunitW3CValidators\Connector\FeedConnector;
use kevintweber\PhpunitW3CValidators\ResponseParser\W3CResponseParser;

class FeedW3CConnector extends FeedConnector
{
    protected $responseArray = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setOutputType("soap12");
        $this->setUrl("http://validator.w3.org/feed/check.cgi");
    }

    protected function getPostVariables()
    {
        return array(
            'output' => $this->getOutputType(),
            'manual' => "1",
            'rawdata' => $this->getInput()
            );
    }

    /**
     * Parses the SOAP 1.2 response.
     *
     * @param string $response The SOAP 1.2 response.
     */
    public function processResponse($response)
    {
        try {
            $dom = new \DOMDocument();
            if ($dom->loadXML($response)) {
                $validityElement = $dom->getElementsByTagName('validity');
                if ($validityElement->length && $validityElement->item(0)->nodeValue == 'true') {
                    return true;
                }
            }
        }
        catch (Exception $e) {
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
        // Parse response.
        $dom = new \DOMDocument();
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

        // Format response text.
        $result = '';

        foreach ($this->responseArray as $problem) {
            $result .= $problem . "\n";
        }

        return $result;
    }
}