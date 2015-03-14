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

interface ConnectorInterface
{
    public function setInput($value);
    public function execute($type);
    public function processResponse($response);
    public function describeFailure($response);
}