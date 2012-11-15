<?php

namespace kevintweber\PhpunitW3CValidators\Assert;

use kevintweber\PhpunitW3CValidators\Connector\CSSConnector;
use kevintweber\PhpunitW3CValidators\Connector\CSSW3CConnector;
use kevintweber\PhpunitW3CValidators\Constraint\Generic;

/**
 * A validator for CSS
 */
class CSS extends \PHPUnit_Framework_Assert
{
    /**
     * Asserts that the CSS string is valid.
     *
     * @param string         $css        The markup to be validated.
     * @param string         $message    Test message.
     * @param HTMLConnector  $connector  A connector to a CSS validation service.
     */
    public static function IsValidMarkup($css,
										 $message = '',
										 CSSConnector $connector = null)
    {
        // Check that $css is a string.
        if (empty($css) || !is_string($css)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(
                1, 'string'
                );
        }

		// Assign connector if there isn't one already.
		if ($connector === null) {
			$connector = new CSSW3CConnector();
		}

		// Parse the html.
        $connector->setInput($css);
        $response = $connector->execute();

		// Tell PHPUnit of the results.
        $constraint = new Generic($connector);
        self::assertThat($response, $constraint, $message);
    }

	/**
     * Asserts that the CSS file is valid.
     *
     * @param string         $path       The file path to be validated.
     * @param string         $message    Test message.
     * @param HTMLConnector  $connector  A connector to a CSS validation service.
     */
    public static function IsValidFile($path,
									   $message = '',
									   CSSConnector $connector = null)
    {
        // Check that $path is exists.
        if (!file_exists($path)) {
			throw new PHPUnit_Framework_Exception(
				sprintf('File "%s" does not exist.' . "\n", $path)
			);
        }

		// Get file contents.
		$css = file_get_contents($path);
		if ($css === false) {
            throw new PHPUnit_Framework_Exception(
				sprintf('Cannot read file "%s".' . "\n", $path)
			);
		}

		// Assign connector if there isn't one already.
		if ($connector === null) {
			$connector = new CSSW3CConnector();
		}

		// Parse the html.
        $connector->setInput($css);
        $response = $connector->execute();

		// Tell PHPUnit of the results.
        $constraint = new Generic($connector);
        self::assertThat($response, $constraint, $message);
    }
}