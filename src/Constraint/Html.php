<?php

namespace kevintweber\PhpunitW3CValidators\Constraint;

use kevintweber\PhpunitW3CValidators\Connector\HTMLConnector;

class HTML extends PHPUnit_Framework_Constraint
{
    /**
     * The service connector.
     */
    protected $connector;

    /**
     * Constructor
     */
    public function __construct(HTMLConnector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Evaluates the constraint for parameter $other. Returns TRUE if the
     * constraint is met, FALSE otherwise.
     *
     * @param mixed $other Value or object to evaluate.
     * @return bool
     */
    protected function matches($other)
    {
        return $this->connector->processResult($other);
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString()
    {
        return 'is valid';
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param mixed $other Evaluated value or object.
     * @return string
     */
    protected function failureDescription($other)
    {
        return 'the markup ' . $this->toString();
    }

    /**
     * Return additional failure description where needed
     *
     * The function can be overridden to provide additional failure
     * information like a diff
     *
     * @param mixed $other Evaluated value or object.
     * @return string
     */
    protected function additionalFailureDescription($other)
    {
        return $other;
    }
}