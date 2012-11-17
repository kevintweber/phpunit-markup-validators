<?php

/*
 * This file is part of the PhpunitW3CValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpunitW3CValidators\Assert;

use kevintweber\PhpunitW3CValidators\Assert\HTML;

class HTMLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers kevintweber\PhpunitW3CValidators\Asssert\HTML::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        HTML::IsValidMarkup("<div><span>Whoa</span></div>",
                            "Valid HTML 4 fragment.");

        try {
            HTML::IsValidMarkup("<div><span>Whoa<p>Bad</span></div></p>",
                                 "Invalid HTML 4 fragment.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }
}