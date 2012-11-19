# HTML and CSS Validation for PHPUnit

This is an extension for [PHPUnit][phpunit] that uses online services for markup validation.

<table>
<thead>
<tr><th>Class</th><th>Validates</th><th>Service</th></tr>
</thead>
<tbody>
<tr><td>HTML5</td><td>HTML5</td><td>http://html5.validator.nu/</td></tr>
<tr><td>HTML</td><td>HTML and XHTML</td><td>http://validator.w3.org/</td></tr>
<tr><td>CSS</td><td>CSS Levels 1-3</td><td>http://jigsaw.w3.org/css-validator/</td></tr>
<tr><td>Feed</td><td>RSS and Atom feeds</td><td>http://validator.w3.org/feed/</td></tr>
</tbody>
</table>

## Installation

1) Install [Composer][composer].

2) In your composer.json file, add the following:

    {
        "require": {
            "kevintweber/PhpunitW3CValidators": "1.*"
        }
    }

3) Run "composer install".

4) Watch the magic happen ...

This library and all it's dependencies will be downloaded to your "vendor" directory.  [Composer][composer] offers many VERY USEFUL features.  Read the composer documentation: it will be worth your time.

## Usage

1) Build a test case as below:

Here is an example of a minimal test case that will pass.

```php
<?php

require_once("vendor/autoload.php");

use kevintweber\PhpunitW3CValidators\Assert\Html5;

class test extends PHPUnit_Framework_TestCase
{
    public function testHTMLValidation()
    {
        HTML5::IsValidMarkup("<div>Whoa</div>", "Optional custom message.");
    }
}
```

2) From your console, run "php vendor/bin/phpunit \<path/to/tests\>"

Each assert class has three methods:

1) IsValidMarkup(string $markup, string $message = '', Connector $connector = null) - Passes test if $markup is valid markup.

2) IsValidFile(string $pathToFile, string $message = '', Connector $connector = null) - Passes test if file at $pathToFile has valid markup.

3) IsValidUrl(string $URL, string $message = '', Connector $connector = null) - Passes test if webpage at $URL has valid markup.

In the event that a test fails, first the $message will be displayed, then a detailed error report will be listed.

(The third parameter is for custom connectors, in case you want to extend this library with your own services.)

Note: Each online service requests that API usage does not exceed 1 request per second.  I have included a throttle class to limit requests.  An easy workaround is to not use the same test class repeatedly, but rather alternate test classes.

## Authors
Kevin Weber - kevintweber@gmail.com

## License
PhpunitW3CValidators is licensed under the MIT license.  See `LICENSE` for more details.

## Acknowledgements
Parts were inspired from [xvoland/html-validate].

[composer]: http://getcomposer.org/
[phpunit]: https://github.com/sebastianbergmann/phpunit
[validator.nu]: http://validator.nu
[validator.nu/presets]: http://about.validator.nu/#presets
[validator.nu/tos]: http://about.validator.nu/#tos
[xvoland/html-validate]: https://github.com/xvoland/html-validate
