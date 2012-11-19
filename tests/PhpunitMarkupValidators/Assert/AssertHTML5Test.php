<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpunitMarkupValidators\Assert;

use kevintweber\PhpunitMarkupValidators\Assert\AssertHTML5;

class AssertHTML5Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers kevintweber\PhpunitMarkupValidators\Asssert\AssertHTML5::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        // Test valid HTML5 markup.
        AssertHTML5::IsValidMarkup("<section><div>Whoa</div></section>",
                                   "Valid HTML5 fragment.");

        // Test invalid HTML5 markup.
        try {
            AssertHTML5::IsValidMarkup("<section><div>Whoa</section></div>",
                                       "Invalid HTML5 fragment.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertHTML5::IsValidFile
     */
    public function testIsValidFile()
    {
        // Test valid HTML5 file.
        AssertHTML5::IsValidFile(realpath(__DIR__ . "/../../files/HTML5_Valid.html"),
                                 "Valid HTML5 file.");

        // Test invalid HTML5 file.
        try {
            AssertHTML5::IsValidFile(realpath(__DIR__ . "/../../files/HTML5_Invalid.html"),
                                     "Invalid HTML5 file.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();

    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertHTML5::IsValidUrl
     */
    public function testIsValidUrl()
    {
        // Test valid HTML5 url.
        AssertHTML5::IsValidUrl("http://www.w3.org/html/Activity.html", "Valid HTML5 url.");
    }
}