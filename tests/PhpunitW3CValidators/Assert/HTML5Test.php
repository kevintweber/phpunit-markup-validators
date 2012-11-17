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

use kevintweber\PhpunitW3CValidators\Assert\HTML5;

class HTML5Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers kevintweber\PhpunitW3CValidators\Asssert\HTML5::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        HTML5::IsValidMarkup("<section><div>Whoa</div></section>",
                             "Valid HTML5 fragment.");

        try {
            HTML5::IsValidMarkup("<section><div>Whoa</section></div>",
                                 "Invalid HTML5 fragment.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitW3CValidators\Assert::IsValidFile
     */
    public function testIsValidFile()
    {
        HTML5::IsValidFile(__DIR__ . "/../files/HTML5_Valid.html",
                           "Valid HTML5 file.");

        try {
            HTML5::IsValidFile(__DIR__ . "/../files/HTML5_Invalid.html",
                               "Invalid HTML5 file.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();

    }

    /**
     * @covers kevintweber\PhpunitW3CValidators\Assert::IsValidUrl
     */
    public function testIsValidUrl()
    {
        HTML5::IsValidUrl("http://www.w3.org/TR/html5/", "Valid HTML5 url.");
    }
}