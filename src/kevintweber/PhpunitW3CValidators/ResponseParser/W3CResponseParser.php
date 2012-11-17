<?php

/*
 * This file is part of the PhpunitW3CValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kevintweber\PhpunitW3CValidators\ResponseParser;

use kevintweber\PhpunitW3CValidators\ResponseParser\ResponseParser;

class W3CResponseParser extends ResponseParser
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