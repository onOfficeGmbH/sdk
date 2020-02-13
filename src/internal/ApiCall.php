<?php

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2016, onOffice(R) Software AG
 * @license MIT
 *
 */


namespace onOffice\SDK\internal;

use onOffice\SDK\Cache\onOfficeSDKCache;
use onOffice\SDK\Exception\ApiCallFaultyResponseException;
use onOffice\SDK\Exception\ApiCallNoActionParametersException;
use onOffice\SDK\Exception\HttpFetchNoResultException;
use onOffice\SDK\internal\ApiAction;
use onOffice\SDK\internal\Request;


/**
 *
 */

class ApiCall
{
	/** @var Request[] */
	private $_requestQueue = array();

	/** @var array */
	private $_responses = array();

	/** @var array */
	private $_errors = array();

	/** @var string */
	private $_apiVersion = 'latest';

	/** @var onOfficeSDKCache[] */
	private $_caches = array();

	/** @var string */
	private $_server = null;

	/** @var array */
	private $_curlOptions = array();


	/**
	 *
	 * @param string $actionId
	 * @param string $resourceId
	 * @param string $identifier
	 * @param string $resourceType
	 * @param array $parameters
	 *
	 * @return int the request handle
	 *
	 */

	public function callByRawData($actionId, $resourceId, $identifier, $resourceType, $parameters = array())
	{
		$pApiAction = new ApiAction($actionId, $resourceType, $parameters, $resourceId, $identifier);

		$pRequest = new Request($pApiAction);
		$requestId = $pRequest->getRequestId();
		$this->_requestQueue[$requestId] = $pRequest;

		return $requestId;
	}

	/**
	 *
	 * @param string $token
	 * @param string $secret
	 * @param HttpFetch|null $httpFetch
	 * @throws HttpFetchNoResultException
	 */

	public function sendRequests($token, $secret, HttpFetch $httpFetch = null)
	{
		$this->collectOrGatherRequests($token, $secret, $httpFetch);
	}

	/**
	 *
	 * @param string $token
	 * @param array $actionParameters
	 * @param array $actionParametersOrder
	 * @param \onOffice\SDK\internal\HttpFetch|null $httpFetch
	 * @throws HttpFetchNoResultException
	 */

	private function sendHttpRequests(
		$token,
		array $actionParameters,
		array $actionParametersOrder,
		HttpFetch $httpFetch = null
	) {
		if (count($actionParameters) === 0)
		{
			return;
		}

		$responseHttp = $this->getFromHttp($token, $actionParameters, $httpFetch);

		$result = json_decode($responseHttp, true);


		if (!isset($result['response']['results']))
		{
			throw new HttpFetchNoResultException;
		}

		$idsForCache = array();

		foreach ($result['response']['results'] as $requestNumber => $resultHttp)
		{
			$pRequest = $actionParametersOrder[$requestNumber];
			$requestId = $pRequest->getRequestId();

			if ($resultHttp['status']['errorcode'] == 0)
			{
				$this->_responses[$requestId] = new Response($pRequest, $resultHttp);
				$idsForCache []= $requestId;
			}
			else
			{
				$this->_errors[$requestId] = $resultHttp;
			}
		}
		$this->writeCacheForResponses($idsForCache);
	}

	/**
	 *
	 * @param string $token
	 * @param string $secret
	 * @param HttpFetch|null $httpFetch
	 * @throws HttpFetchNoResultException
	 */

	private function collectOrGatherRequests($token, $secret, HttpFetch $httpFetch = null)
	{
		$actionParameters = array();
		$actionParametersOrder = array();

		foreach ($this->_requestQueue as $requestId => $pRequest)
		{
			$usedParameters = $pRequest->getApiAction()->getActionParameters();
			$cachedResponse = $this->getFromCache($usedParameters);

			if ($cachedResponse === null)
			{
				$parametersThisAction = $pRequest->createRequest($token, $secret);

				$actionParameters[] = $parametersThisAction;
				$actionParametersOrder[] = $pRequest;
			}
			else
			{
				$this->_responses[$requestId] = new Response($pRequest, $cachedResponse);
			}
		}

		$this->sendHttpRequests($token, $actionParameters, $actionParametersOrder, $httpFetch);
		$this->_requestQueue = array();
	}


	/**
	 *
	 */

	private function writeCacheForResponses(array $responses)
	{
		if (count($this->_caches) === 0)
		{
			return;
		}

		$responseObjects = array_intersect_key($this->_responses, array_flip($responses));

		foreach ($responseObjects as $pResponse)
		{
			/* @var $pResponse Response */
			if ($pResponse->isCacheable())
			{
				$responseData = $pResponse->getResponseData();
				$requestParameters = $pResponse->getRequest()->getApiAction()->getActionParameters();
				$this->writeCache(serialize($responseData), $requestParameters);
			}
		}
	}


	/**
	 *
	 * @param array $parameters
	 * @return array
	 *
	 */

	private function getFromCache($parameters)
	{
		foreach ($this->_caches as $pCache)
		{
			$resultCache = $pCache->getHttpResponseByParameterArray($parameters);

			if ($resultCache != null)
			{
				return unserialize($resultCache);
			}
		}

		return null;
	}


	/**
	 *
	 * @param string $result
	 *
	 */

	private function writeCache($result, $actionParameters)
	{
		foreach ($this->_caches as $pCache)
		{
			$pCache->write($actionParameters, $result);
		}
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
	 * @param string $token
	 * @param array $actionParameters
	 * @param \onOffice\SDK\internal\HttpFetch|null $httpFetch
	 * @return string
	 * @throws HttpFetchNoResultException
	 */

	private function getFromHttp(
		$token,
		$actionParameters,
		HttpFetch $httpFetch = null
	) {

		$request = array
			(
				'token' => $token,
				'request' => array('actions' => $actionParameters),
			);

		if (null === $httpFetch) {
			$httpFetch = new HttpFetch($this->getApiUrl(), json_encode($request));
			$httpFetch->setCurlOptions($this->_curlOptions);
		}

		$response = $httpFetch->send();

		return $response;
	}


	/**
	 *
	 * @param int $handle
	 * @return array
	 * @throws ApiCallFaultyResponseException
	 *
	 */

	public function getResponse($handle)
	{
		if (array_key_exists($handle, $this->_responses))
		{
			/* @var $pResponse Response */
			$pResponse = $this->_responses[$handle];

			if (!$pResponse->isValid())
			{
				throw new ApiCallFaultyResponseException('Handle: '.$handle);
			}

			unset($this->_responses[$handle]);

			// do not return $pResponse itself
			return $pResponse->getResponseData();
		}
	}


	/**
	 *
	 * @return string
	 *
	 */

	private function getApiUrl()
	{
		return $this->_server.urlencode($this->_apiVersion).'/api.php';
	}


	/**
	 *
	 * @param string $apiVersion
	 *
	 */

	public function setApiVersion($apiVersion)
	{
		$this->_apiVersion = $apiVersion;
	}


	/**
	 *
	 * @param string $server
	 *
	 */

	public function setServer($server)
	{
		$this->_server = $server;
	}

	/**
	 *
	 * @return array
	 *
	 */

	public function getErrors()
	{
		return $this->_errors;
	}


	/**
	 *
	 * @param onOfficeSDKCache $pCache
	 *
	 */

	public function addCache(onOfficeSDKCache $pCache)
	{
		$this->_caches []= $pCache;
	}


	/**
	 *
	 */

	public function removeCacheInstances() {
		$this->_caches = array();
	}
}
