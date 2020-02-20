<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2016, onOffice(R) Software AG
 * @license MIT
 *
 */

namespace onOffice\SDK\Exception;

/**
 *
 */

class HttpFetchNoResultException extends SDKException
{
	/** @var int */
	private $_curlErrno = null;


	/**
	 *
	 * @return int
	 *
	 */

	public function getCurlErrno()
	{
		return $this->_curlErrno;
	}


	/**
	 *
	 * @param int $errno
	 *
	 */

	public function setCurlErrno($errno)
	{
		$this->_curlErrno = $errno;
	}
}
