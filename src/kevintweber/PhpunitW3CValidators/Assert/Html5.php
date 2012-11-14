<?php

namespace kevintweber\PhpunitW3CValidators\Assert;

use kevintweber\PhpunitW3CValidators\Connector\HTMLConnector;
use kevintweber\PhpunitW3CValidators\Connector\HTML5ValidatorNuConnector;
use kevintweber\PhpunitW3CValidators\Constraint\HTML;

class HTML5 extends PHPUnit_Framework_Assert
{
    /**
     * Asserts that the HTML string is valid.
     *
     * @param string         $html       The markup to be validated.
     * @param string         $message    Test message.
     * @param HTMLConnector  $connector  A connector to a HTML5 validation service.
     */
    public static function IsValid($html,
                                   $message = '',
                                   HTMLConnector $connector = null)
    {
        // Check that $html is a string.
        if (empty($html) || !is_string($html)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(
                1, 'string'
                );
        }

		// Assign connector if there isn't one already.
		if ($connector === null) {
			$connector = new HTML5ValidatorNuConnector();
		}

		// Parse the html.
        $connector->setInput($html);
        $response = $connector->execute();

		// Tell PHPUnit of the results.
        $constraint = new HTML($connector);
        self::assertThat($response, $constraint, $message);
    }
}