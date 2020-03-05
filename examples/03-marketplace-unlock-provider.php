<?php

include __DIR__ . '/../vendor/autoload.php';

use onOffice\SDK\onOfficeSDK;

$pSDK = new onOfficeSDK();
$pSDK->setApiVersion('stable');

$parameterCacheId = '<insert parameterCacheId from IFrame url>';

$parameterUnlockProvider = ['parameterCacheId' => $parameterCacheId];

$handleUnlockProvider = $pSDK->callGeneric(
	onOfficeSDK::ACTION_ID_DO,
	'unlockProvider',
	$parameterUnlockProvider
);

$pSDK->sendRequests('put the token here', 'and secret here');

var_export($pSDK->getResponseArray($handleUnlockProvider));