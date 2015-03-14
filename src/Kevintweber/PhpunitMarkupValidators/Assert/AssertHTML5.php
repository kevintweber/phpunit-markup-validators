<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kevintweber\PhpunitMarkupValidators\Assert;

use Kevintweber\PhpunitMarkupValidators\Connector\ConnectorInterface;
use Kevintweber\PhpunitMarkupValidators\Connector\HTML5ValidatorNuConnector;
use Kevintweber\PhpunitMarkupValidators\Constraint\GenericConstraint;

class AssertHTML5 extends \PHPUnit_Framework_Assert
{
    /**
     * Asserts that the HTML5 string is valid.
     *
     * @param string             $html      The markup to be validated.
     * @param string             $message   Test message.
     * @param ConnectorInterface $connector Connector to HTML5 validation service.
     */
    public static function isValidMarkup($html,
                                         $message = '',
                                         ConnectorInterface $connector = null)
    {
        // Check that $html is a string.
        if (empty($html) || !is_string($html)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        // Assign connector if there isn't one already.
        if ($connector === null) {
            $connector = new HTML5ValidatorNuConnector();
        }

        // Validate the html.
        $connector->setInput($html);
        $response = $connector->execute('markup');

        // Tell PHPUnit of the results.
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }

    /**
     * Asserts that the HTML5 file is valid.
     *
     * @param string             $path      The file path to be validated.
     * @param string             $message   Test message.
     * @param ConnectorInterface $connector Connector to HTML5 validation service.
     */
    public static function isValidFile($path,
                                       $message = '',
                                       ConnectorInterface $connector = null)
    {
        // Check that $path is exists.
        if (!file_exists($path)) {
            throw new \PHPUnit_Framework_Exception(
                sprintf('File "%s" does not exist.'."\n", $path)
            );
        }

        // Get file contents.
        $html = file_get_contents($path);
        if ($html === false) {
            throw new \PHPUnit_Framework_Exception(
                sprintf('Cannot read file "%s".'."\n", $path)
            );
        }

        // Assign connector if there isn't one already.
        if ($connector === null) {
            $connector = new HTML5ValidatorNuConnector();
        }

        // Parse the html.
        $connector->setInput($html);
        $response = $connector->execute('file');

        // Tell PHPUnit of the results.
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }

    /**
     * Asserts that the HTML5 url is valid.
     *
     * @param string             $url       The external url to be validated.
     * @param string             $message   Test message.
     * @param ConnectorInterface $connector Connector to HTML5 validation service.
     */
    public static function isValidURL($url,
                                      $message = '',
                                      ConnectorInterface $connector = null)
    {
        // Check that $url is a string.
        if (empty($url) || !is_string($url)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        // Check that $url is a valid url.
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \PHPUnit_Framework_Exception("Url is not valid.\n");
        }

        // Assign connector if there isn't one already.
        if ($connector === null) {
            $connector = new HTML5ValidatorNuConnector();
        }

        // Parse the html.
        $connector->setInput($url);
        $response = $connector->execute('url');

        // Tell PHPUnit of the results.
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }
}
