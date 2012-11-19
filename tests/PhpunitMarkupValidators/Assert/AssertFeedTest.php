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

use kevintweber\PhpunitMarkupValidators\Assert\AssertFeed;

class AssertFeedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertFeed::IsValidMarkup
     */
    public function testIsValidMarkup()
    {
        // Test valid feed markup.
        AssertFeed::IsValidMarkup('<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0"><channel><title>RSS Title</title><description>RSS feed</description><link>http://www.someexamplerssdomain.com/main.html</link><lastBuildDate>Mon, 06 Sep 2010 00:01:00 +0000 </lastBuildDate><pubDate>Mon, 06 Sep 2010 16:45:00 +0000 </pubDate><ttl>1800</ttl>
<item><title>Example</title><description>text description</description><link>http://www.example.com/</link><guid>http://www.example.com/123</guid><pubDate>Mon, 06 Sep 2010 16:45:00 +0000</pubDate></item></channel></rss>',
                                  "Valid RSS markup.");

        // Test invalid feed markup.
        try {
            AssertFeed::IsValidMarkup('<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0"><channel><title>RSS Title</title><description>RSS feed</description><link>http://www.someexamplerssdomain.com/main.html</link><lastBuildDate>Mon, 06 Sep 2010 00:01:00 +0000 </lastBuildDate><pubDate>Mon, 06 Sep 2010 16:45:00 +0000 </pubDate><ttl>1800</ttl>
<item><title>Example</title><description>text description</description><link>http://www.example.com/</link><guid>http://www.example.com/123</guid><pubDate>Mon, 06 Sep 2010 16:45:00 +0000</pubDate>',
                                      "Invalid RSS markup.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertFeed::IsValidFile
     */
    public function testIsValidFile()
    {
        // Test valid RSS 2.0 file.
        AssertFeed::IsValidFile(realpath(__DIR__ . "/../../files/RSS20_Valid.rss"),
                                "Valid RSS 2.0 file.");

        // Test invalid RSS 2.0 file.
        try {
            AssertFeed::IsValidFile(realpath(__DIR__ . "/../../files/RSS20_Invalid.rss"),
                                    "Invalid RSS 2.0 file.");
        }
        catch (\PHPUnit_Framework_AssertionFailedError $e) {
            return;
        }

        $this->fail();
    }

    /**
     * @covers kevintweber\PhpunitMarkupValidators\Assert\AssertFeed::IsValidUrl
     */
    public function testIsValidUrl()
    {
        // Test valid HTML url.
        AssertFeed::IsValidUrl("http://www.w3.org/News/news.rss", "Valid RSS url.");
    }
}