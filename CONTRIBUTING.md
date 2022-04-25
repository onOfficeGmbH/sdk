# Contributing

When contributing to this service,
please open an issue via the
[GitHub issues page](https://github.com/onOfficeGmbH/sdk/issues)
or send a mail to `apisupport@onoffice.de`
before making a change.

## Bugs

Bugs must be reported via the
[GitHub issues page](https://github.com/onOfficeGmbH/sdk/issues).

Bug fixes and improvements can be provided via a
[Pull Request](https://github.com/onOfficeGmbH/sdk/pulls).

A fix that introduces a change in behavior is considered a
[breaking change](#breaking-changes).

## Features

Features and Breaking Changes must be discussed with the
maintainers of this repository.

A feature that introduces a change in existing behavior is considered a
[breaking change](#breaking-changes).

## Breaking Changes

A breaking change must be discussed with the maintainers.
The list of maintainers can be found [here](https://github.com/orgs/onOfficeGmbH/people)

## Pull Request Process

* Update the `README.md` with details of changes to the interface, classes or
  general behaviour.
* Contact one of the maintainers in the Pull Request.
  The list of maintainers can be found [here](https://github.com/orgs/onOfficeGmbH/people)
* Every Pull Request with actual code changes has to add or adapt unit and/or integration tests. 
  Please see [Running the Tests](#running-the-tests) down below.
* Create a meaningful title for the Pull Request that addresses the topic.
* The Pull Request must pass the CI integration.
  Be aware of the currently supported PHP versions and optimize your code according
  to the supported versions.
* Keep the Pull Request as small as possible.
  Avoid unnecessary changes to speed up the review process.
* Write readable and understandable code.
  Try always to create the best possible solution.
* Use readable and understandable commit messages, so the reviewer can understand the
  intention of each commit.

## Running the Tests

The tests of this project consist on two [test suites](https://phpunit.readthedocs.io/en/9.5/organizing-tests.html).
These are named _unit_ and _integration_ for unit tests and integration tests, respectively.
Running the unit tests should be no harder that running
`./vendor/bin/phpunit --testsuite unit`,  while executing the integration tests requires the binaries `faketime` and `ncat`
to be in the `$PATH`. The integration tests can be run by typing
`./vendor/bin/phpunit --testsuite integration`.