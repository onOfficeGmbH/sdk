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

class ApiAction
{
	/** @var array */
	private $_actionParameters = array();


	/**
	 *
	 * @param string $actionid
	 * @param string $resourceType
	 * @param array $parameters
	 * @param string $resourceId
	 * @param string $identifier
	 *
	 */

	public function __construct($actionid, $resourceType, $parameters, $resourceId = '', $identifier = '')
	{
		ksort($parameters);
		$this->_actionParameters['actionid'] = $actionid;
		$this->_actionParameters['identifier'] = $identifier;
		$this->_actionParameters['parameters'] = $parameters;
		$this->_actionParameters['resourceid'] = $resourceId;
		$this->_actionParameters['resourcetype'] = $resourceType;
	}


	/**
	 *
	 * @return array
	 *
	 */

	public function getActionParameters()
	{
		return $this->_actionParameters;
	}


	/**
	 *
	 * @return string
	 *
	 */

	public function getIdentifier()
	{
		return md5(serialize($this->_actionParameters));
	}
}
