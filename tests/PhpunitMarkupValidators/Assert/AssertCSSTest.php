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

use kevintweber\PhpunitMarkupValidators\Assert\AssertCSS;

class AssertCSSTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertCSS::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        // Test valid CSS markup.
        AssertCSS::IsValidMarkup("div{color:black;}");

        // Test invalid CSS markup.
        try {
            AssertCSS::IsValidMarkup("div{color:badcolordude!;}");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertCSS::IsValidFile
     */
    public function testIsValidFile()
    {
        // Test valid CSS file.
        AssertCSS::IsValidFile(realpath(__DIR__ . "/../../files/CSS_Valid.css"),
                               "Valid CSS file.");

        // Test invalid CSS file.
        try {
            AssertCSS::IsValidFile(realpath(__DIR__ . "/../../files/CSS_Invalid.css"),
                                   "Invalid CSS file.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertCSS::IsValidUrl
     */
    public function testIsValidUrl()
    {
        AssertCSS::IsValidUrl("http://www.w3.org/StyleSheets/TR/W3C-WG-NOTE.css",
                              "Valid CSS url.");
    }
}