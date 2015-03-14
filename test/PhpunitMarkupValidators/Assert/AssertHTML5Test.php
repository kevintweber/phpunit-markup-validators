<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\PhpunitMarkupValidators\Assert;

use Kevintweber\PhpunitMarkupValidators\Assert\AssertHTML5;

class AssertHTML5Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Kevintweber\PhpunitMarkupValidators\Asssert\AssertHTML5::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        // Test valid HTML5 markup.
        AssertHTML5::isValidMarkup(
            "<section><div>Whoa</div></section>",
            "Valid HTML5 fragment."
        );

        // Test invalid HTML5 markup.
        try {
            AssertHTML5::isValidMarkup(
                "<section><div>Whoa</section></div>",
                "Invalid HTML5 fragment."
            );
        } catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers Kevintweber\PhpunitMarkupValidators\Assert\AssertHTML5::IsValidFile
     */
    public function testIsValidFile()
    {
        // Test valid HTML5 file.
        AssertHTML5::isValidFile(
            realpath(__DIR__."/../../files/HTML5_Valid.html"),
            "Valid HTML5 file."
        );

        // Test invalid HTML5 file.
        try {
            AssertHTML5::isValidFile(
                realpath(__DIR__."/../../files/HTML5_Invalid.html"),
                "Invalid HTML5 file."
            );
        } catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }
}
