<?php

namespace kevintweber\PhpunitW3CValidators\ResponseParser;

abstract class ResponseParser
{
	/**
	 * Helper function for parsing SOAP 1.2 responses.
	 *
	 * @param array       $tagNameArray  An array of tag names to extract data from.
	 * @param DOMNodeList $nodeList The  DOM node list.
	 *
	 * @return array An array of tag name indexed results.
	 */
	protected function parseSoap12(array $tagNameArray, \DOMElement $DOMElement)
	{
		$result = array();

		foreach ($tagNameArray as $tagName) {
			$element = $DOMElement->getElementsByTagName($tagName);

			if ($element->length) {
				$result[$tagName] = $element->item(0)->nodeValue;
			}
		}

		return $result;
	}
}