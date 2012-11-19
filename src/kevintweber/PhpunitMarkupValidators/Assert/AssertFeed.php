<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kevintweber\PhpunitMarkupValidators\Assert;

use kevintweber\PhpunitMarkupValidators\Connector\FeedConnector;
use kevintweber\PhpunitMarkupValidators\Connector\FeedW3CConnector;
use kevintweber\PhpunitMarkupValidators\Constraint\GenericConstraint;

/**
 * A validator for both RSS and Atom feeds.
 */
class AssertFeed extends \PHPUnit_Framework_Assert
{
    /**
     * Asserts that the feed string is valid.
     *
     * @param string         $feed       The feed text to be validated.
     * @param string         $message    Test message.
     * @param FeedConnector  $connector  A connector to a HTML validation service.
     */
    public static function IsValidMarkup($feed,
                                         $message = '',
                                         FeedConnector $connector = null)
    {
        // Check that $feed is a string.
        if (empty($feed) || !is_string($feed)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(
                1, 'string'
                );
        }

        // Assign connector if there isn't one already.
        if ($connector === null) {
            $connector = new FeedW3CConnector();
        }

        // Validate the feed.
        $connector->setInput($feed);
        $response = $connector->execute('markup');

        // Tell PHPUnit of the results.
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }

    /**
     * Asserts that the feed file is valid.
     *
     * @param string         $path       The file path to be validated.
     * @param string         $message    Test message.
     * @param FeedConnector  $connector  A connector to a HTML5 validation service.
     */
    public static function IsValidFile($path,
                                       $message = '',
                                       FeedConnector $connector = null)
    {
        // Check that $path is exists.
        if (!file_exists($path)) {
            throw new \PHPUnit_Framework_Exception(
                sprintf('File "%s" does not exist.' . "\n", $path)
                );
        }

        // Get file contents.
        $feed = file_get_contents($path);
        if ($feed === false) {
            throw new \PHPUnit_Framework_Exception(
                sprintf('Cannot read file "%s".' . "\n", $path)
                );
        }

        // Assign connector if there isn't one already.
        if ($connector === null) {
            $connector = new FeedW3CConnector();
        }

        // Validate the feed
        $connector->setInput($feed);
        $response = $connector->execute('file');

        // Tell PHPUnit of the results.
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }

    /**
     * Asserts that the feed url is valid.
     *
     * @param string         $url        The external url to be validated.
     * @param string         $message    Test message.
     * @param FeedConnector  $connector  A connector to a HTML5 validation service.
     */
    public static function IsValidURL($url,
                                      $message = '',
                                      FeedConnector $connector = null)
    {
        // Check that $url is a string.
        if (empty($url) || !is_string($url)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(
                1, 'string'
                );
        }

        // Check that $url is a valid url.
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \PHPUnit_Framework_Exception("Url is not valid.\n");
        }

        // Assign connector if there isn't one already.
        if ($connector === null) {
            $connector = new FeedW3CConnector();
        }

        // Validate the feed
        $connector->setInput($url);
        $response = $connector->execute('url');

        // Tell PHPUnit of the results.
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }
}