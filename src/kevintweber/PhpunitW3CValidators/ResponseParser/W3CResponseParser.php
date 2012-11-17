<?php

namespace kevintweber\PhpunitW3CValidators\ResponseParser;

use kevintweber\PhpunitW3CValidators\ResponseParser\ResponseParser;
use kevintweber\PhpunitW3CValidators\Util\SelfDescribing;

class W3CResponseParser extends ResponseParser implements SelfDescribing
{
    protected $response = array('type' => null,
                                'data' => array());

    /**
     * Constructor
     *
     * @param DOMElement $DOMElement
     */
    public function __construct($type, \DOMElement $DOMElement)
    {
        $this->response['type'] = $type;
        $this->response['data'] = $this->parseSoap12(array('line', 'message'), $DOMElement);
    }

    public function __toString()
    {
        $lineResponse = '';
        if (isset($this->response['data']['line'])) {
            $lineResponse = " on line " . trim($this->response['data']['line']);
        }

        return $this->response['type'] . $lineResponse . ": " .
            trim($this->response['data']['message']);
    }
}