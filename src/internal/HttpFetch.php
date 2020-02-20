<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2016, onOffice(R) Software AG
 * @license MIT
 *
 */


namespace onOffice\SDK\internal;

use onOffice\SDK\Exception\HttpFetchNoResultException;


/**
 *
 */

class HttpFetch
{
	/** @var string */
	private $_url = '';

	/** @var string */
	private $_postData = '';

	/** @var array */
	private $_curlOptions = array();


	/**
	 *
	 * @param string $url
	 * @param string $postData as JSON
	 *
	 */

	public function __construct($url, $postData)
	{
		$this->_url = $url;
		$this->_postData = $postData;
	}


	/**
	 *
	 * @param array $curlOptions
	 *
	 */

	public function setCurlOptions($curlOptions)
	{
		$this->_curlOptions = $curlOptions;
	}


	/**
	 *
	 * @return string
	 * @throws HttpFetchNoResultException
	 *
	 */

	public function send()
	{
		$curlVersionInfo = curl_version();
		$curlVersionNumber = $curlVersionInfo['version_number'];

		$curlResource = curl_init($this->_url);
		curl_setopt($curlResource, CURLOPT_POST, true);

		if (version_compare(PHP_VERSION, '5.5.0', '>=') &&
			$curlVersionNumber >= 0x072106)
		{
			// empty string = all supported compressions
			curl_setopt($curlResource, CURLOPT_ACCEPT_ENCODING, '');
		}
		elseif (version_compare(PHP_VERSION, '5.5.0', '>=') &&
			$curlVersionNumber >= 0x071506) // 7.15.06
		{
			curl_setopt($curlResource, CURLOPT_ENCODING, '');
		}

		curl_setopt($curlResource, CURLOPT_POSTFIELDS, $this->_postData);
		curl_setopt($curlResource, CURLOPT_RETURNTRANSFER, true);

		foreach ($this->_curlOptions as $option => $value)
		{
			curl_setopt($curlResource, $option, $value);
		}

		$result = curl_exec($curlResource);

		if (!$result)
		{
			$info = curl_error($curlResource);
			$pException = new HttpFetchNoResultException($info);
			$pException->setCurlErrno(curl_errno($curlResource));
			throw $pException;
		}

		return $result;
	}
}
