# Changelog

## 0.3.0 (2026-10-19)

* Require PHP 7.2.5 or newer (#71 by @mpfeifer-onOffice)
  * This is more of a formality. Previously no requirement was explicitly stated but PHP 7.2.5
    was implicitly required because of dependencies and PHP 7.2 features being used in the SDK.
* Sign requests according to version 2 of the onOffice API HMAC (#42 by @AndrejThomsen)
* Initialize the timestamp parameter if it is not set manually (#47 by @AndrejThomsen)
* Use the `'stable'` instead of the `'latest'` API version by default (#30 by @legionth)
* Add example for unlocking a marketplace provider (#25 by @legionth)
* add the extended claim to it (#54 by @Bohn-onOffice)
* Document the difference between call and callGeneric in the README (#60 by @legionth)
* Adapt docblocks and remove the p-prefix from member variables (#21, #29 by @legionth)
* Add integration test (#49 by @jayay)
* Run tests on GitHub Actions and keep dependencies up to date with Dependabot
  (#34, #35 by @jayay)
* adapt the test suite to PHPUnit 8 (#73 by @mpfeifer-onOffice)
* run all tests in a Docker container (#75 by @mpfeifer-onOffice)

## 0.2.0 (2020-02-24)

* Fix description of composer command in README (#10 by @mrcodefinger)
* Add Travis to CI pipeline (#22 by @dkaisers, #7 by @legionth)
* Adding PHP-CS-Fixer as development dependency (#19 by @legionth)
* Move example to examples folder (#20 by @legionth)
* Introduced PHPUnit (#11, #12, #13, #14, #15, #16, #18 by @legionth)
* Rename SDK folder to src folder and update autoloader according to changes (#9 by @legionth)
* Added PSR-4 Autoloader via composer (#6 by @legionth)

## 0.1.0 (2020-02-12)

* Improve documentation of the README and create CONTRIBUTING document
  for developers (#2 and #3 by @legionth)
* Add composer.json to identify dependencies and adding the repository
  to packagist.org (#1 and #4 by @legionth)
