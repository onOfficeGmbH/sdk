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
		$secret = 'someSecret';
		$token = 'someToken';

		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);
		$result = $request->createRequest($token, $secret);

		$fields = [
			'timestamp' => $result['timestamp'],
			'token' => $token,
			'resourcetype' => $result['resourcetype'],
			'actionid' => $result['actionid'],
		];
		$hmac = base64_encode(hash_hmac('sha256',implode('',$fields),$secret,true));

		$this->assertGreaterThan(0, $result['timestamp']);
		$this->assertEquals('someResourceId', $result['resourceid']);
		$this->assertEquals('someIdentifier', $result['identifier']);
		$this->assertEquals([], $result['parameters']);
		$this->assertEquals('someActionId', $result['actionid']);
		$this->assertEquals('someResourceType', $result['resourcetype']);
		$this->assertGreaterThanOrEqual(2, $result['hmac_version']);
		$this->assertEquals($hmac, $result['hmac']);
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