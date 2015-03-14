<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kevintweber\PhpunitMarkupValidators\Connector;

use Kevintweber\PhpunitMarkupValidators\Util\Throttle;

abstract class Connector implements ConnectorInterface
{
    protected $input;
    protected $outputType;
    protected $url;

    /**
     * Will execute a cURL request.
     *
     * @param string $type The type of input.
     *
     * @return mixed The response from the web service.
     */
    public function execute($type)
    {
        switch (strtolower($type)) {
        case 'markup':
            $curlOptArray = $this->getMarkupOpts();
            break;

        case 'file':
            $curlOptArray = $this->getFileOpts();
            break;

        case 'url':
            $curlOptArray = $this->getUrlOpts();
            break;

        default:
            throw new \PHPUnit_Framework_Exception('Invalid type: '.$type);
            break;
        }

        $curlOptArray = $curlOptArray + array(CURLOPT_RETURNTRANSFER => true,
                                              CURLOPT_TIMEOUT => 10, );

        // Throttle calls (if necessary).
        Throttle::delay(get_class($this));

        $curl = curl_init();
        curl_setopt_array($curl, $curlOptArray);

        if (!$response = curl_exec($curl)) {
            throw new \PHPUnit_Framework_Exception('Unable to validate. Error: '.
                                                   curl_error($curl));
        }

        curl_close($curl);

        return $response;
    }

    abstract protected function getMarkupOpts();
    abstract protected function getFileOpts();
    abstract protected function getUrlOpts();

    /**
     * Process the result from the service.
     *
     * @param mixed $result The result from the service.
     *
     * @return bool True is valid.
     */
    abstract public function processResponse($response);

    /**
     * A helper function to parse the validation service response.
     *
     * @param string $response The response text.
     *
     * @return string A description of the failure.
     */
    public function describeFailure($response)
    {
        return $response;
    }

    /**
     * Getter for 'input'.
     *
     * @return string The value of 'input'
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Setter for 'input'.
     *
     * @param string $value The new value of 'input'
     */
    public function setInput($value)
    {
        $this->input = $value;
    }

    /**
     * Getter for 'outputType'.
     *
     * @return string The value of 'outputType'
     */
    public function getOutputType()
    {
        return $this->outputType;
    }

    /**
     * Setter for 'outputType'.
     *
     * @param string $value The new value of 'outputType'
     */
    public function setOutputType($value)
    {
        $this->outputType = $value;
    }

    /**
     * Getter for 'url'.
     *
     * @return string The value of 'url'
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Setter for 'url'.
     *
     * @param string $value The new value of 'url'
     */
    public function setUrl($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new \PHPUnit_Framework_Exception("Url is not valid.\n");
        }

        $this->url = $value;
    }
}
