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
     * @covers kevintweber\PhpunitW3CValidators\Asssert\CSS::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        CSS::IsValidMarkup("div{color:black;}");

        try {
            CSS::IsValidMarkup("div{color:badcolordude!;}");
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
        CSS::IsValidUrl("http://www.w3.org/StyleSheets/TR/W3C-WG-NOTE.css",
                        "Valid CSS url.");
    }
}