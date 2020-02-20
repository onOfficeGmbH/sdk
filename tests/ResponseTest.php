<?php

namespace Tests\onOffice\SDK;

use onOffice\SDK\internal\ApiAction;
use onOffice\SDK\internal\Request;
use onOffice\SDK\internal\Response;

class ResponseTest extends \PHPUnit\Framework\TestCase
{
	public function testIsValid()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$response = new Response($request, [
			'actionid' => 'someActionId',
			'resourcetype' => 'someResourceType',
			'data' => 'someData'
		]);

		$result = $response->isValid();

		$this->assertTrue($result);
	}

	public function testIsInvalid()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$response = new Response($request, []);

		$result = $response->isValid();

		$this->assertFalse($result);
	}

	public function testIsNotCacheable()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$response = new Response($request, [
			'actionid' => 'someActionId',
			'resourcetype' => 'someResourceType',
			'data' => 'someData',
			'cacheable' => true
		]);

		$result = $response->isCacheable();

		$this->assertTrue($result);
	}

	public function testIsNotCacheableBecauseResponseHasBooleanFlag()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$response = new Response($request, [
			'actionid' => 'someActionId',
			'resourcetype' => 'someResourceType',
			'data' => 'someData',
			'cacheable' => false
		]);

		$result = $response->isCacheable();

		$this->assertFalse($result);
	}

	public function testIsNotCacheableBecauseResponseIsInvalid()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$response = new Response($request, [
			'cacheable' => true
		]);

		$result = $response->isCacheable();

		$this->assertFalse($result);
	}

	public function testIsNotCacheableBecauseResponseBooleanFlagIsMissing()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$response = new Response($request, [
			'actionid' => 'someActionId',
			'resourcetype' => 'someResourceType',
			'data' => 'someData'
		]);

		$result = $response->isCacheable();

		$this->assertFalse($result);
	}

	public function testGetRequest()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$response = new Response($request, [
			'actionid' => 'someActionId',
			'resourcetype' => 'someResourceType',
			'data' => 'someData'
		]);

		$result = $response->getRequest();

		$this->assertSame($request, $result);
	}

	public function testGetResponseData()
	{
		$apiAction = new ApiAction(
			'someActionId',
			'someResourceType',
			[],
			'someResourceId',
			'someIdentifier'
		);

		$request = new Request($apiAction);

		$responseData = [
			'actionid' => 'someActionId',
			'resourcetype' => 'someResourceType',
			'data' => 'someData'
		];

		$response = new Response(
			$request, $responseData
		);

		$result = $response->getResponseData();

		$this->assertSame($responseData, $result);
	}
}
