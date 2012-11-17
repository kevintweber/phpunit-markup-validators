<?php

namespace kevintweber\PhpunitW3CValidators\Connector;

abstract class Connector
{
    protected $input;
    protected $outputType;
    protected $port;
    protected $url;
    protected $userAgent;

    /**
     * Constructor
     *
     * @param string $input The markup to be tested.
     */
    public function __construct()
    {
        $this->port = null;
        $this->userAgent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
    }

    /**
     * Will execute the cURL post request.
     *
     * @return mixed $response  The reponse from the web service.
     */
    public function execute()
    {
        // Set cURL opts.
        $curlOpt = array(
            CURLOPT_USERAGENT      => $this->userAgent,
            CURLOPT_URL            => $this->url,
            CURLOPT_PORT           => $this->port,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $this->getPostVariables(),
            CURLOPT_HTTPHEADER     => array('Content-Type: text/plain')
            );

        $curl = curl_init();
        curl_setopt_array($curl, $curlOpt);

        if (!$response = curl_exec($curl)) {
            throw new PHPUnit_Framework_Exception(
                sprintf('Unable to validate. cURL returning error %s',
                        trigger_error(curl_error($curl))
                    )
                );
        }

        curl_close($curl);

        return $response;
    }

    /**
     * The post variables are service specific.
     *
     * @return array The post variables.
     */
    abstract protected function getPostVariables();

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
     * Getter for 'port'.
     *
     * @return int|null The value of 'port'
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Setter for 'port'.
     *
     * @param int|null $value The new value of 'port'
     */
    public function setPort($value)
    {
        $this->port = $value;
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
        if ('http' != substr($value, 0, 4)) {
            $value = 'http://' . $value;
        }

        $this->url = $value;
    }

    /**
     * Getter for 'userAgent'.
     *
     * @return string The value of 'userAgent'
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Setter for 'userAgent'.
     *
     * @param string $value The new value of 'userAgent'
     */
    public function setUserAgent($value)
    {
        $this->userAgent = $value;
    }
}