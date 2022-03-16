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
		$secret = 'yOJobbhGLXdp90XxvxedFhH7073L9U';
		$token = 'mgjIQkNRnaqggVzy9cZW';

		$apiAction = new ApiAction(
			'urn:onoffice-de-ns:smart:2.5:smartml:action:get',
			'estateCategories',
			[],
			'someResourceId',
			'someIdentifier',
			123456789
		);

		$request = new Request($apiAction);
		$result = $request->createRequest($token, $secret);

		$this->assertGreaterThan(0, $result['timestamp']);
		$this->assertEquals('someResourceId', $result['resourceid']);
		$this->assertEquals('someIdentifier', $result['identifier']);
		$this->assertEquals([], $result['parameters']);
		$this->assertEquals('urn:onoffice-de-ns:smart:2.5:smartml:action:get', $result['actionid']);
		$this->assertEquals('estateCategories', $result['resourcetype']);
		$this->assertGreaterThanOrEqual(2, $result['hmac_version']);
		$this->assertEquals('dsvg3r4AFcQXges0MZ+3auzQVfnEB39pLkKSgmm9Wvg=', $result['hmac']);
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