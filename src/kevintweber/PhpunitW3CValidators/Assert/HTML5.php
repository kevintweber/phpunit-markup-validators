<?php

namespace kevintweber\PhpunitW3CValidators\Assert;

use kevintweber\PhpunitW3CValidators\Connector\HTMLConnector;
use kevintweber\PhpunitW3CValidators\Connector\HTML5ValidatorNuConnector;
use kevintweber\PhpunitW3CValidators\Constraint\GenericConstraint;
use Symfony\Component\Process\Process;

class HTML5 extends \PHPUnit_Framework_Assert
{
    /**
     * Asserts that the HTML5 string is valid.
     *
     * @param string         $html       The markup to be validated.
     * @param string         $message    Test message.
     * @param HTMLConnector  $connector  A connector to a HTML5 validation service.
     */
    public static function IsValidMarkup($html,
                                         $message = '',
                                         HTMLConnector $connector = null)
    {
        // Check that $html is a string.
        if (empty($html) || !is_string($html)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(
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
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }

    /**
     * Asserts that the HTML5 file is valid.
     *
     * @param string         $path       The file path to be validated.
     * @param string         $message    Test message.
     * @param HTMLConnector  $connector  A connector to a HTML5 validation service.
     */
    public static function IsValidFile($path,
                                       $message = '',
                                       HTMLConnector $connector = null)
    {
        // Check that $path is exists.
        if (!file_exists($path)) {
            throw new \PHPUnit_Framework_Exception(
                sprintf('File "%s" does not exist.' . "\n", $path)
                );
        }

        // Get file contents.
        $html = file_get_contents($path);
        if ($html === false) {
            throw new \PHPUnit_Framework_Exception(
                sprintf('Cannot read file "%s".' . "\n", $path)
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
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }

    /**
     * Asserts that the HTML5 url is valid.
     *
     * @param string         $url        The external url to be validated.
     * @param string         $message    Test message.
     * @param HTMLConnector  $connector  A connector to a HTML5 validation service.
     */
    public static function IsValidURL($url,
                                      $message = '',
                                      HTMLConnector $connector = null)
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
            $connector = new HTML5ValidatorNuConnector();
        }

        // Get the source.
        $process = new Process('wget ' . $url);
        $process->setTimeout(10);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \PHPUnit_Framework_Exception($process->getErrorOutput());
        }

        // Parse the html.
        $connector->setInput($process->getOutput());
        $response = $connector->execute();

        // Tell PHPUnit of the results.
        $constraint = new GenericConstraint($connector);
        self::assertThat($response, $constraint, $message);
    }
}