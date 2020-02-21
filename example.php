<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2016-2018, onOffice(R) GmbH
 * @license MIT
 *
 */

include __DIR__ . '/vendor/autoload.php';

use onOffice\SDK\onOfficeSDK;

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


// Sometimes however, you will have to set the `resourceId` parameter. In This case, you can use the call() method.
// Example:

$parametersSearchEstate = [
	'input' => 'Aachen',
];

$handleSearchEstate = $pSDK->call(onOfficeSDK::ACTION_ID_GET, 'estate', '', 'search', $parametersSearchEstate);
$pSDK->sendRequests('put the token here', 'and secret here');

var_export($pSDK->getResponseArray($handleSearchEstate));