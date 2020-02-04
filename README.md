# onOffice-SDK

This project is the official PHP API client for the
[onOffice API](https://apidoc.onoffice.de/)
supported by the onOffice GmbH.

* **The HTTP protocol** is used to communicate with the API.
* An **Access Token** is used to ensure a **secure** communication with the API.
* The intention is to a **lightweight** client that can be used in other environments

**Table of Contents**
* [Quickstart Example](#quickstart-example)
* [Usage](#usage)
  * [Client](#client)
  * [Parameters](#parameters)
* [API Documentation](#api-documentation)
* [Contributing](#contributing)
* [License](#license)

## Quickstart Example

```php
$pSDK = new onOfficeSDK();
$pSDK->setApiVersion('latest');

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

$handleReadEstate = $pSDK->callGeneric(onOfficeSDK::ACTION_ID_READ, 'estate', $parametersReadEstate);

$pSDK->sendRequests('put the token here', 'and secret here');

var_export($pSDK->getResponseArray($handleReadEstate));
```

Checkout the [example](/example.php) to see a possible implementation of
this client.

## Usage

### Client

The `onOfficeSDK` is responsible for creating HTTP Requests and
receiving HTTP Responses from the official API

```php
$pSDK = new onOfficeSDK();
$pSDK->setApiVersion('latest');
```

Make sure that the correct API version is used for your client.
By default this value is set to `latest`.

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

## API Documentation

The API client is developed for the current version of the official API version.
Additional information about the API can be [found here](https://apidoc.onoffice.de/).

## Contributing

If you want to contribute to this project, we would appreciate if you send us an email to

apisupport@onoffice.de

## License

This project is licensed under the MIT License. See [LICENSE document](/LICENSE).