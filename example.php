<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2016-2018, onOffice(R) GmbH
 * @license MIT
 *
 */

include 'Psr4AutoloaderClass.php';
use onOffice\SDK\Psr4AutoloaderClass;
use onOffice\SDK\onOfficeSDK;

$pAutoloader = new Psr4AutoloaderClass();

// register path to our files (namespace onOffice)
$pAutoloader->addNamespace('onOffice', __DIR__);
$pAutoloader->register();

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
