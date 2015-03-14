# Markup Validation for PHPUnit

This is an extension for [PHPUnit][phpunit] that uses online services for markup validation.

<table>
<thead>
<tr><th>Class</th><th>Validates</th><th>Service</th></tr>
</thead>
<tbody>
<tr><td>AssertHTML5</td><td>HTML5</td><td>http://html5.validator.nu/</td></tr>
</tbody>
</table>

## Installation

1) Install [Composer][composer].

2) `composer require kevintweber/phpunit-markup-validators`<br />or add it to your composer.json file.

3) Install [PHPUnit][phpunit].

Note: I have removed PHPUnit as a composer dependency for folks who run PHPUnit globally.  To install PHPUnit locally, use: `composer require phpunit/phpunit`

## Usage

Here is an example of a minimal test case that will pass.

```php
<?php

require_once("vendor/autoload.php");

use Kevintweber\PhpunitMarkupValidators\Assert\AssertHtml5;

class HtmlTest extends PHPUnit_Framework_TestCase
{
    public function testHTMLValidation()
    {
        AssertHTML5::isValidMarkup("<div>Whoa</div>", "Optional custom message.");
    }
}
```

Each assert class has three methods:

1) `isValidMarkup(string $markup, string $message = '', Connector $connector = null)`<br />Passes test if $markup is valid markup.

2) `isValidFile(string $pathToFile, string $message = '', Connector $connector = null)`<br />Passes test if file at $pathToFile has valid markup.

3) `isValidUrl(string $URL, string $message = '', Connector $connector = null)`<br />Passes test if webpage at $URL has valid markup.

In the event that a test fails, first the $message will be displayed, then a detailed error report will be listed.

(The third parameter is for custom connectors, in case you want to extend this library with your own services.)

Note: Each online service requests that API usage does not exceed 1 request per second.  I have included a throttle class to limit requests.  An easy workaround is to not use the same test class repeatedly, but rather alternate test classes.

## Authors
Kevin Weber - kevintweber@gmail.com

## License
phpunit-markup-validators is licensed under the MIT license.  See `LICENSE` for more details.

## Acknowledgements
Parts were inspired from [xvoland/html-validate].

[composer]: http://getcomposer.org/
[phpunit]: https://github.com/sebastianbergmann/phpunit
[validator.nu]: http://validator.nu
[validator.nu/presets]: http://about.validator.nu/#presets
[validator.nu/tos]: http://about.validator.nu/#tos
[xvoland/html-validate]: https://github.com/xvoland/html-validate
