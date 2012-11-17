<?php

/*
 * This file is part of the PhpunitW3CValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kevintweber\PhpunitW3CValidators\Connector;

use kevintweber\PhpunitW3CValidators\Connector\HTMLConnector;

class HTML5ValidatorNuConnector extends HTMLConnector
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setOutputType("text");
        $this->setUrl("http://html5.validator.nu/");
    }

    protected function getPostVariables()
    {
        return array(
            'out' => $this->getOutputType(),
            'content' => $this->getInput()
            );
    }

    public function processResponse($result)
    {
        if (stripos($result, 'Error') !== false || stripos($result, 'Warning') !== false) {
            return false;
        }

        return true;
    }
}