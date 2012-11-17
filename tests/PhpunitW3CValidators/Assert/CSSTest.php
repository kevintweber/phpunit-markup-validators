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

use kevintweber\PhpunitW3CValidators\Assert\CSS;

class CSSTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers kevintweber\PhpunitW3CValidators\Assert\CSS::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        // Test valid CSS markup.
        CSS::IsValidMarkup("div{color:black;}");

        // Test invalid CSS markup.
        try {
            CSS::IsValidMarkup("div{color:badcolordude!;}");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitW3CValidators\Assert\HTML:IsValidFile
     */
    public function testIsValidFile()
    {
        // Test valid CSS file.
        CSS::IsValidFile(realpath(__DIR__ . "/../../files/CSS_Valid.css"),
                          "Valid CSS file.");

        // Test invalid CSS file.
        try {
            CSS::IsValidFile(realpath(__DIR__ . "/../../files/CSS_Invalid.css"),
                              "Invalid CSS file.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitW3CValidators\Assert::IsValidUrl
     */
    /* public function testIsValidUrl() */
    /* { */
    /*     CSS::IsValidUrl("http://www.w3.org/StyleSheets/TR/W3C-WG-NOTE.css", */
    /*                     "Valid CSS url."); */
    /* } */
}