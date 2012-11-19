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

use kevintweber\PhpunitMarkupValidators\Assert\AssertHTML;

class AssertHTMLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertHTML::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        // Test valid HTML markup.
        AssertHTML::IsValidMarkup("<div><span>Whoa</span></div>",
                                  "Valid HTML fragment.");

        // Test invalid HTML markup.
        try {
            AssertHTML::IsValidMarkup("<div><span>Whoa<p>Bad</span></div></p>",
                                      "Invalid HTML fragment.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertHTML::IsValidFile
     */
    public function testIsValidFile()
    {
        // Test valid HTML 4.01 file.
        AssertHTML::IsValidFile(realpath(__DIR__ . "/../../files/HTML4_Valid.html"),
                                "Valid HTML 4.01 file.");

        // Test invalid HTML 4.01 file.
        try {
            AssertHTML::IsValidFile(realpath(__DIR__ . "/../../files/HTML4_Invalid.html"),
                                    "Invalid HTML 4.01 file.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertHTML::IsValidUrl
     */
    public function testIsValidUrl()
    {
        // Test valid HTML url.
        AssertHTML::IsValidUrl("http://www.w3.org/TR/1999/REC-html401-19991224/",
                               "Valid HTML url.");
    }
}