<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2016-2018, onOffice(R) GmbH
 * @license MIT
 *
 */

include __DIR__ . '/../vendor/autoload.php';

use onOffice\SDK\onOfficeSDK;

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
