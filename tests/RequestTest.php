<?php

namespace Tests\onOffice\SDK;

use onOffice\SDK\internal\ApiAction;
use onOffice\SDK\internal\Request;

class RequestTest extends \PHPUnit\Framework\TestCase
{
	public function testGetApiAction()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);
		$request = new Request($apiAction);

		$result = $request->getApiAction();

		$this->assertSame($apiAction, $result);
	}

	public function testCreateRequest()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);
		$result = $request->createRequest('someToken', 'someSecret');

		$this->assertGreaterThan(0, $result['timestamp']);
		$this->assertEquals('someResourceId', $result['resourceid']);
		$this->assertEquals('someIdentifier', $result['identifier']);
		$this->assertEquals([], $result['parameters']);
		$this->assertEquals('someActionId', $result['actionid']);
		$this->assertEquals('someResourceType', $result['resourcetype']);
		$this->assertGreaterThan(0, strlen($result['hmac']));
	}

	public function testGetRequestId()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);
		$request = new Request($apiAction);

		$result = $request->getRequestId();

		$this->assertGreaterThan(0, $result);
	}
}