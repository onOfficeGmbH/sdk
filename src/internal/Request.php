<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2016, onOffice(R) Software AG
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
		$actionParameters['timestamp'] = time();
		$timestamp = $actionParameters['timestamp'];

		$id = $actionParameters['resourceid'];
		$identifier = $actionParameters['identifier'];
		$parameters = $actionParameters['parameters'];
		$actionId = $actionParameters['actionid'];
		$type = $actionParameters['resourcetype'];
		$hmac = $this->createHmac($id, $token, $secret, $timestamp, $identifier, $type, $parameters, $actionId);
		$actionParameters['hmac'] = $hmac;

		return $actionParameters;
	}


	/**
	 *
	 * @param string $id
	 * @param string $token
	 * @param string $secret
	 * @param string $timestamp
	 * @param string $identifier
	 * @param string $type
	 * @param string $parameters
	 * @param string $actionId
	 * @return string
	 *
	 */

	private function createHmac($id, $token, $secret, $timestamp, $identifier, $type, $parameters, $actionId)
	{
		// in alphabetical order
		$fields['accesstoken'] = $token;
		$fields['actionid'] = $actionId;
		$fields['identifier'] = $identifier;
		$fields['resourceid'] = $id;
		$fields['secret'] = $secret;
		$fields['timestamp'] = $timestamp;
		$fields['type'] = $type;

		ksort($parameters);

		$parametersBundled = json_encode($parameters);
		$fieldsBundled = implode(',', $fields);
		$allParams = $parametersBundled.','.$fieldsBundled;
		$hmac = md5($secret.md5($allParams));

		return $hmac;
	}


	/** @return int */
	public function getRequestId()
		{ return $this->_requestId; }

	/** @return ApiAction */
	public function getApiAction()
		{ return $this->_pApiAction; }
}
