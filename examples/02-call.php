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

$parametersSearchEstate = [
	'input' => 'Aachen',
];

$handleSearchEstate = $sdk->call(onOfficeSDK::ACTION_ID_GET, 'estate', '', 'search', $parametersSearchEstate);

$sdk->sendRequests('put the token here', 'and secret here');

var_export($sdk->getResponseArray($handleSearchEstate));
