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

class Response
{
	/** @var Request */
	private $_pRequest = null;

	/** @var array */
	private $_responseData = null;


	/**
	 *
	 * @param Request $pRequest
	 * @param array $responseData
	 *
	 */

	public function __construct(Request $pRequest, array $responseData)
	{
		$this->_pRequest = $pRequest;
		$this->_responseData = $responseData;
	}


	/**
	 *
	 * @return bool
	 *
	 */

	public function isValid()
	{
		return isset($this->_responseData['actionid']) &&
			isset($this->_responseData['resourcetype']) &&
			isset($this->_responseData['data']);
	}


	/**
	 *
	 * @return bool
	 *
	 */

	public function isCacheable()
	{
		return $this->isValid() && isset($this->_responseData['cacheable']) &&
			$this->_responseData['cacheable'];
	}


	/** @return Request */
	public function getRequest()
		{ return $this->_pRequest; }

	/** @return array */
	public function getResponseData()
		{ return $this->_responseData; }
}
