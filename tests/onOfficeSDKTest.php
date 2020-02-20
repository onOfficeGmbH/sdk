<?php

class onOfficeSDKTest extends \PHPUnit\Framework\TestCase
{
	public function testCreationOfClient()
	{
		$apiCall = $this->getMockBuilder(\onOffice\SDK\internal\ApiCall::class)
			->disableOriginalConstructor()
			->setMethods(['setServer'])
			->getMock();

		$apiCall->expects($this->once())
			->method('setServer')
			->with('https://api.onoffice.de/api/');

		$onOfficeSdk = new \onOffice\SDK\onOfficeSDK($apiCall);
	}


	public function testSetApiVerision()
	{
		$apiCall = $this->getMockBuilder(\onOffice\SDK\internal\ApiCall::class)
			->disableOriginalConstructor()
			->setMethods(['setServer', 'setApiVersion'])
			->getMock();

		$apiCall->expects($this->once())
			->method('setServer')
			->with('https://api.onoffice.de/api/');

		$apiCall->expects($this->once())
			->method('setApiVersion')
			->with('v1');

		$onOfficeSdk = new \onOffice\SDK\onOfficeSDK($apiCall);
		$onOfficeSdk->setApiVersion('v1');
	}

	public function testSetApiCurlOptions()
	{
		$apiCall = $this->getMockBuilder(\onOffice\SDK\internal\ApiCall::class)
			->disableOriginalConstructor()
			->setMethods(['setServer', 'setCurlOptions'])
			->getMock();

		$apiCall->expects($this->once())
			->method('setServer')
			->with('https://api.onoffice.de/api/');

		$apiCall->expects($this->once())
			->method('setCurlOptions')
			->with(['some', 'actions']);

		$onOfficeSdk = new \onOffice\SDK\onOfficeSDK($apiCall);
		$onOfficeSdk->setApiCurlOptions(['some', 'actions']);
	}

	public function testCallGeneric()
	{
		$apiCall = $this->getMockBuilder(\onOffice\SDK\internal\ApiCall::class)
			->disableOriginalConstructor()
			->setMethods(['setServer', 'callByRawData'])
			->getMock();

		$apiCall->expects($this->once())
			->method('setServer')
			->with('https://api.onoffice.de/api/');

		$apiCall->expects($this->once())
			->method('callByRawData')
			->with(
				'someActionId',
				'',
				'',
				'someResourceType',
				['some', 'parameters']
			);

		$onOfficeSdk = new \onOffice\SDK\onOfficeSDK($apiCall);
		$onOfficeSdk->callGeneric(
			'someActionId',
			'someResourceType',
			['some', 'parameters']
		);
	}

	public function testSendRequests()
	{
		$apiCall = $this->getMockBuilder(\onOffice\SDK\internal\ApiCall::class)
			->disableOriginalConstructor()
			->setMethods(['setServer', 'sendRequests'])
			->getMock();

		$apiCall->expects($this->once())
			->method('setServer')
			->with('https://api.onoffice.de/api/');

		$apiCall->expects($this->once())
			->method('sendRequests')
			->with(
				'someToken',
				'someSecret'
			);

		$onOfficeSdk = new \onOffice\SDK\onOfficeSDK($apiCall);
		$onOfficeSdk->sendRequests(
			'someToken',
			'someSecret'
		);
	}

	public function testGetResponseArray()
	{
		$apiCall = $this->getMockBuilder(\onOffice\SDK\internal\ApiCall::class)
			->disableOriginalConstructor()
			->setMethods(['setServer', 'getResponse'])
			->getMock();

		$apiCall->expects($this->once())
			->method('setServer')
			->with('https://api.onoffice.de/api/');

		$apiCall->expects($this->once())
			->method('getResponse')
			->with(1)
			->willReturn(['some', 'response']);

		$onOfficeSdk = new \onOffice\SDK\onOfficeSDK($apiCall);
		$result = $onOfficeSdk->getResponseArray(1);

		$this->assertEquals(['some', 'response'], $result);
	}

	public function testAddCache()
	{
		$apiCall = $this->getMockBuilder(\onOffice\SDK\internal\ApiCall::class)
			->disableOriginalConstructor()
			->setMethods(['setServer', 'addCache'])
			->getMock();

		$apiCall->expects($this->once())
			->method('setServer')
			->with('https://api.onoffice.de/api/');

		$cache = $this->getMockBuilder(\onOffice\SDK\Cache\onOfficeSDKCache::class)
			->getMock();

		$apiCall->expects($this->once())
			->method('addCache')
			->with($cache);

		$onOfficeSdk = new \onOffice\SDK\onOfficeSDK($apiCall);

		$onOfficeSdk->addCache($cache);
	}
}