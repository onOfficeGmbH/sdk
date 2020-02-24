<?php

namespace Tests\onOffice\SDK;

use onOffice\SDK\Cache\onOfficeSDKCache;
use onOffice\SDK\Exception\HttpFetchNoResultException;
use onOffice\SDK\internal\ApiCall;
use onOffice\SDK\internal\HttpFetch;

class ApiCallTest extends \PHPUnit\Framework\TestCase
{
	public function testCallByRawData()
	{
		$apiCall = new ApiCall();

		$result = $apiCall->callByRawData(
			'someActionId',
			'someResourceId',
			'someIdentifier',
			'someResourceType',
			[]
		);

		$this->assertEquals(0, $result);
	}

	public function testSendRequests()
	{
		$apiCall = new ApiCall();

		$httpFetch = $this->getMockBuilder(HttpFetch::class)
			->disableOriginalConstructor()
			->setMethods(['send'])
			->getMock();

		$id = $apiCall->callByRawData(
			'someActionId',
			'someResourceId',
			'someIdentifier',
			'someResourceType',
			[]
		);

		$array = [
			'response' => [
				'results' => [
					0 => [
						'status' => [
							'errorcode' => 0
						]
					]
				]
			]
		];

		$httpFetch
			->expects($this->once())
			->method('send')
			->willReturn(json_encode($array));

		$apiCall->sendRequests(
			'someToken',
			'someSecret',
			$httpFetch
		);
	}

	public function testSendRequestsWithoutCallByRawData()
	{
		$apiCall = new ApiCall();

		$httpFetch = $this->getMockBuilder(HttpFetch::class)
			->disableOriginalConstructor()
			->setMethods(['send'])
			->getMock();


		$httpFetch
			->expects($this->never())
			->method('send');

		$apiCall->sendRequests(
			'someToken',
			'someSecret',
			$httpFetch
		);
	}

	public function testSendRequestsWithoutProperresponse()
	{
		$this->expectException(HttpFetchNoResultException::class);

		$apiCall = new ApiCall();

		$httpFetch = $this->getMockBuilder(HttpFetch::class)
			->disableOriginalConstructor()
			->setMethods(['send'])
			->getMock();

		$apiCall->callByRawData(
			'someActionId',
			'someResourceId',
			'someIdentifier',
			'someResourceType',
			[]
		);

		$array = [
			'response' => []
		];

		$httpFetch
			->expects($this->once())
			->method('send')
			->willReturn(json_encode($array));

		$apiCall->sendRequests(
			'someToken',
			'someSecret',
			$httpFetch
		);
	}

	/**
	 * @doesNotPerformAssertions
	 */
	public function testSetApiVersion()
	{
		$apiCall = new ApiCall();
		$apiCall->setApiVersion('v1');
	}

	/**
	 * @doesNotPerformAssertions
	 */
	public function testAddCache()
	{
		$cache = $this->getMockBuilder(onOfficeSDKCache::class)
			->getMock();

		$apiCall = new ApiCall();
		$apiCall->addCache($cache);
	}

	/**
	 * @doesNotPerformAssertions
	 */
	public function testRemoveCacheInstances()
	{
		$cache = $this->getMockBuilder(onOfficeSDKCache::class)
			->getMock();

		$apiCall = new ApiCall();
		$apiCall->addCache($cache);
		$apiCall->removeCacheInstances();
	}

	public function testGetErrors()
	{
		$apiCall = new ApiCall();
		$result = $apiCall->getErrors();

		$this->assertEquals([], $result);
	}
}