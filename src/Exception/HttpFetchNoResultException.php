<?php

namespace onOffice\SDK\Exception;

class HttpFetchNoResultException extends SDKException
{
	/** @var int */
	private $_curlErrno = null;


	/**
	 * @return int
	 */

	public function getCurlErrno()
	{
		return $this->_curlErrno;
	}

	/**
	 * @param int $errno
	 */

	public function setCurlErrno($errno)
	{
		$this->_curlErrno = $errno;
	}
}
