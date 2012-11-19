<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kevintweber\PhpunitMarkupValidators\ResponseParser;

use kevintweber\PhpunitMarkupValidators\ResponseParser\W3CResponseParser;

class FeedW3CResponseParser extends W3CResponseParser
{
    /**
     * Constructor
     *
     * @param DOMElement $DOMElement
     */
    public function __construct($type, \DOMElement $DOMElement)
    {
        $this->response['type'] = $type;
        $this->response['data'] = $this->parseW3CFeed($DOMElement);
    }

    /**
     * Custom parser for W3C Feed Soap 1.2 response.
     */
    protected function parseW3CFeed($DOMElement)
    {
        $result = array('line' => '', 'message' => '');

        // Find line.
        $line = $DOMElement->getElementsByTagName('line');

        if ($line->length) {
            $result['line'] = $line->item(0)->nodeValue;
        }

        // Find message.
        $message = $DOMElement->getElementsByTagName('text');

        if ($message->length) {
            $result['message'] = $message->item(0)->nodeValue;
        }

        return $result;
    }
}