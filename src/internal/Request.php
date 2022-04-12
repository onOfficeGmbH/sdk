<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2022, onOffice(R) GmbH
 * @license MIT
 *
 */


namespace onOffice\SDK\internal;


/**
 *
 */

class Request
{
	/** @var ApiAction */
	private $_pApiAction = null;

	/** @var int */
	private $_requestId = null;

	/** @var int */
	private static $_requestIdStatic = 0;


	/**
	 *
	 * @param ApiAction $pApiAction
	 *
	 */

	public function __construct(ApiAction $pApiAction)
	{
		$this->_pApiAction = $pApiAction;
		$this->_requestId = self::$_requestIdStatic++;
	}


	/**
	 *
	 * @param string $token
	 * @param string $secret
	 * @return array
	 *
	 */

	public function createRequest($token, $secret)
	{
		$actionParameters = $this->_pApiAction->getActionParameters();

		$actionParameters['timestamp'] = $actionParameters['timestamp'] ?? time();
		$actionParameters['hmac_version'] = 2;

		$actionId = $actionParameters['actionid'];
		$type = $actionParameters['resourcetype'];
		$hmac = $this->createHmac2( $token, $secret, $actionParameters['timestamp'], $type, $actionId);
		$actionParameters['hmac'] = $hmac;

		return $actionParameters;
	}


	/**
	 *
	 * @param string $token
	 * @param string $secret
	 * @param string $timestamp
	 * @param string $type
	 * @param string $actionId
	 * @return string
	 *
	 */

	private function createHmac2($token, $secret, $timestamp, $type, $actionId)
	{
		$fields = [
			'timestamp' => $timestamp,
			'token' => $token,
			'resourcetype' => $type,
			'actionid' => $actionId,
		];

		return base64_encode(hash_hmac('sha256', implode('',$fields), $secret, true));
	}


	/** @return int */
	public function getRequestId()
	{ return $this->_requestId; }

	/** @return ApiAction */
	public function getApiAction()
	{ return $this->_pApiAction; }
}
