<?php

include __DIR__ . '/../vendor/autoload.php';

use onOffice\SDK\onOfficeSDK;

$pSDK = new onOfficeSDK();
$pSDK->setApiVersion('stable');

$parameterCacheId = '<insert parameterCacheId from IFrame url>';
$extendedClaim = '<insert apiClaim from IFrame url>';
$apiUserToken = '<insert apiToken from IFrame url>';
$apiUserSecret = '<insert posted secret that ther user has copied to your IFrame>';

$parameterUnlockProvider = [
	'parameterCacheId' => $parameterCacheId,
	'extendedclaim' => $extendedClaim
];

$handleUnlockProvider = $pSDK->callGeneric(
	onOfficeSDK::ACTION_ID_DO,
	'unlockProvider',
	$parameterUnlockProvider
);

$pSDK->sendRequests($apiUserToken, $apiUserSecret);

var_export($pSDK->getResponseArray($handleUnlockProvider));