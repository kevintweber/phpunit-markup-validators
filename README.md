# HTML and CSS validation for PHPUnit

This is an extension for [PHPUnit][phpunit] that uses the W3C online validators.

## Installation

1) Install [Composer][composer].

2) In your composer.json file, add the following:

    {
        "repositories": [
            {
			    "type": "vcs",
                "url": "http://github.com/kevintweber/PhpunitW3CValidators"
            }
        ],
        "require": {
            "kevintweber/PhpunitW3CValidators": "*"
        },
	    "minimum-stability": "dev"
    }

3) Run "composer install".

4) Watch the magic happen ...

This library and all it's dependencies will be downloaded to your "vendor" directory.  [Composer][composer] offers many VERY USEFUL features.  Read the composer documentation: it will be worth your time.

## Usage

Here is an example of a minimal test case that will pass.

    <?php

    require_once("vendor/autoload.php");

    use kevintweber\PhpunitW3CValidators\Assert\Html5;

    class test extends PHPUnit_Framework_TestCase
    {
	    public function testHTMLValidation()
	    {
		    Html5::IsValid("<div>Whoa</div>", "Optional custom message.");
	    }
    }

## License
The HTML validator uses the excellent [validator.nu].  Please read the [Terms of service][validator.nu/tos] for validator.nu.

PhpunitW3CValidators is licensed under the MIT license.  See `LICENSE` for more details.

## Authors
Parts were inspired from [xvoland/html-validate].

[composer]: http://getcomposer.org/
[phpunit]: https://github.com/sebastianbergmann/phpunit
[validator.nu]: http://validator.nu
[validator.nu/presets]: http://about.validator.nu/#presets
[validator.nu/tos]: http://about.validator.nu/#tos
[xvoland/html-validate]: https://github.com/xvoland/html-validate
