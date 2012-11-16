<?php

namespace kevintweber\PhpunitW3CValidators\Connector;

use kevintweber\PhpunitW3CValidators\Connector\HTMLConnector;
use kevintweber\PhpunitW3CValidators\ResponseParser\W3CResponseParser;

class HTMLW3CConnector extends HTMLConnector
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setOutputType("soap12");
        $this->setUrl("http://validator.w3.org/check");
    }

    protected function getPostVariables()
    {
        return array(
            'output' => $this->getOutputType(),
            'uploaded_file' => $this->getInput()
            );
    }

    /**
     * Parses the SOAP 1.2 response.
     *
     * @todo Need to parse warnings and errors.
     *
     * @param string $result The SOAP 1.2 response.
     */
    public function processResponse($response)
    {
        $dom = new \DOMDocument();
        if ($dom->loadXML($response)) {
            $validityElement = $dom->getElementsByTagName('validity');
            if ($validityElement->length && $validityElement->item(0)->nodeValue == 'true') {
                return true;
            }
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