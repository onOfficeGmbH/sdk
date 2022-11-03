# onOffice-SDK
[![PHP Composer](https://github.com/onOfficeGmbH/sdk/actions/workflows/php.yml/badge.svg)](https://github.com/onOfficeGmbH/sdk/actions/workflows/php.yml)

This project is the official PHP API client for the
[onOffice API](https://apidoc.onoffice.de/)
supported by the onOffice GmbH.

* **The HTTP protocol** is used to communicate with the API.
* An **Access Token** and **TLS connection** are used to ensure a **secure**
  communication with the API.
* The intention is to have **lightweight** client that can be used in other environments

**Table of Contents**
* [Quickstart Example](#quickstart-example)
* [Usage](#usage)
  * [Client](#client)
  * [Parameters](#parameters)
  * [Request](#request)
  * [Response](#response)
* [API Documentation](#api-documentation)
* [Install](#install)
* [Contributing](#contributing)
* [License](#license)

## Quickstart Example

```php
$sdk = new onOfficeSDK();
$sdk->setApiVersion('stable');

$parametersReadEstate = [
	'data' => [
		'Id',
		'kaufpreis',
		'lage',
	],
	'listlimit' => 10,
	'sortby' => [
		'kaufpreis' => 'ASC',
		'warmmiete' => 'ASC',
	],
	'filter' => [
		'kaufpreis' => [
			['op' => '>', 'val' => 300000],
		],
		'status' => [
			['op' => '=', 'val' => 1],
		],
	],
];

$handleReadEstate = $sdk->callGeneric(onOfficeSDK::ACTION_ID_READ, 'estate', $parametersReadEstate);

$sdk->sendRequests('put the token here', 'and secret here');

var_export($sdk->getResponseArray($handleReadEstate));
```

Checkout the [examples folder](/examples/) to see a possible implementation of
this client.

## Usage

### Client

The `onOfficeSDK` is responsible for creating HTTP Requests and
receiving HTTP Responses from the official API

```php
$sdk = new onOfficeSDK();
$sdk->setApiVersion('stable');
```

Make sure that the correct API version is used for your client.
By default this value is set to `stable`.

### Parameters

The parameters are transferred as JSON in the HTTP Request.
The client uses the official
[PHP array notation](https://www.php.net/manual/en/book.json.php)
before transforming the array to JSON.

```php
$parametersReadEstate = [
	'data' => [
		'Id',
		'kaufpreis',
		'lage',
	],
	'listlimit' => 10,
	'sortby' => [
		'kaufpreis' => 'ASC',
		'warmmiete' => 'ASC',
	],
	'filter' => [
		'kaufpreis' => [
			['op' => '>', 'val' => 300000],
		],
		'status' => [
			['op' => '=', 'val' => 1],
		],
	],
];
```

### Request

To create a request to the API an `ACTION_ID` is needed.
The class `onOfficeSDK` defines several constants,
that can be used, so there is no need to copy these `ACTION_IDs`. 

A token and secret are needed to send a request to the API.
Check out the [official API documentation](#api-documentation)
for information on how to acquire these credentials.

```php
$handleReadEstate = $sdk->callGeneric(onOfficeSDK::ACTION_ID_READ, 'estate', $parametersReadEstate);

$sdk->sendRequests('put the token here', 'and secret here');
```

The return value of `onOfficeSDK::callGeneric` is used to identify the
equivalent response value.
`onOfficeSDK::callGeneric` can be called multiple times before sending
the request to the API via `onOfficeSDK::sendRequests`.


### Response

Use the method `onOfficeSDK::getResponseArray` to fetch the response data for a request.
To identify the response of the request, use the value returned by `onOfficeSDK::callGeneric`.
```php
var_export($sdk->getResponseArray($handleReadEstate));
```

The response will be a PHP array.

### Difference between `call` and `callGeneric`

This library will provide two general methods that to create the calls to the onOffice API.

* `callGeneric` is used to create simple calls e.g. 
   [Estate searches](https://apidoc.onoffice.de/actions/datensatz-lesen/objekte/)
   or
  [reading addresses](https://apidoc.onoffice.de/actions/datensatz-lesen/adressen/)
* `call` can be used more specific for special API Requests.
  Some API Request need some more information like `identifier`, `resourceId` and `resourceType`
  to be processed.
  This can be calls like [Estate files](https://apidoc.onoffice.de/actions/informationen-abfragen/objektdateien/)
  or [Editing Addresses](https://apidoc.onoffice.de/actions/datensatz-bearbeiten/addresses/)

Check the [API documentation](#api-documentation) for more information.

## API Documentation

The API client is developed for the latest version of the official API.
Additional information about the API can be [found here](https://apidoc.onoffice.de/).

## Install

The recommended way to install this library is through Composer. 
[New to Composer?](https://getcomposer.org/)

This will install the latest supported version:

```
$ composer require onoffice/sdk:^0.2.0
```
See also the [CHANGELOG](/CHANGELOG.md)
for details about version upgrades.

## Contributing

You want to contribute? Great!

Check out our [contribution rules](/CONTRIBUTING.md) and get started!

## License

This project is licensed under the MIT License. See [LICENSE document](/LICENSE).
