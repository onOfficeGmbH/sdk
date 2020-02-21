<?php

namespace Tests\onOffice\SDK;

use onOffice\SDK\internal\ApiAction;

class ApiActionTest extends \PHPUnit\Framework\TestCase
{
	public function testDefaultCreationOfActionParameters()
	{
		$parameters = [
			'param1' => 'value1',
			[
				'param2' => 'value2',
				'param3' => 'value3'
			]
		];

		$apiAction = new ApiAction(
			'someId',
			'someResource',
			$parameters
		);

		$result = $apiAction->getActionParameters();

		$expectation = [
			'actionid' => 'someId',
			'identifier' => '',
			'parameters' => [
				'param1' => 'value1',
				[
					'param2' => 'value2',
					'param3' => 'value3'
				]
			],
			'resourceid' => '',
			'resourcetype' => 'someResource'
		];

		$this->assertEquals($expectation, $result);
	}

	public function testDefaultIdentifier()
	{
		$parameters = [
			'param1' => 'value1',
			[
				'param2' => 'value2',
				'param3' => 'value3'
			]
		];

		$apiAction = new ApiAction(
			'someId',
			'someResource',
			$parameters
		);

		$result = $apiAction->getIdentifier();

		$this->assertEquals('d419f822aba1c1c59a4c76b690a1c86a', $result);
	}

	public function testCustomCreationOfActionParameters()
	{
		$parameters = [
			'param1' => 'value1',
			[
				'param2' => 'value2',
				'param3' => 'value3'
			]
		];

		$apiAction = new ApiAction(
			'someId',
			'someResource',
			$parameters,
			'someResourceId',
			'someIdentifier'
		);

		$result = $apiAction->getActionParameters();

		$expectation = [
			'actionid' => 'someId',
			'identifier' => 'someIdentifier',
			'parameters' => [
				'param1' => 'value1',
				[
					'param2' => 'value2',
					'param3' => 'value3'
				]
			],
			'resourceid' => 'someResourceId',
			'resourcetype' => 'someResource'
		];

		$this->assertEquals($expectation, $result);
	}

	public function testCustomIdentifier()
	{
		$parameters = [
				'param1' => 'value1',
				[
					'param2' => 'value2',
					'param3' => 'value3'
				]
		];

		$apiAction = new ApiAction(
			'someId',
			'someResource',
			$parameters,
			'someResourceId',
			'someIdentifier'
		);

		$result = $apiAction->getIdentifier();

		$this->assertEquals('7919bb645be5d61927052c22867a4f52', $result);
	}
}