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
	 * @param DOMNodeList $nodeList A DOMNodeList object
	 */
	public function __construct($type, \DOMNodeList $nodeList)
	{
		$this->response['type'] = $type;
		$this->response['data'] = $this->parseSoap12(array('line', 'message'), $nodeList);
	}

	public function __toString()
	{
		return $this->response['type'] . " on line " . $this->response['data']['line'] .
			": " . $this->response['message'];
	}
}