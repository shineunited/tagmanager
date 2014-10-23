<?php

namespace ShineUnited\TagManager\Tests;

use ShineUnited\TagManager\DataLayer;
use ShineUnited\TagManager\Message;


class DataLayerTest extends \PHPUnit_Framework_TestCase {


	public function testPush() {
		$datalayer = new DataLayer();

		$message = new Message([
			'hello' => 'world',
			'foo'   => [
				'bar',
				'baz'
			]
		]);

		$datalayer->push($message);

		$this->assertEquals([$message->send()], $datalayer->send());
	}

	public function testPushException1() {
		$datalayer = new DataLayer();

		$this->setExpectedException('InvalidArgumentException');

		$datalayer->push('hello world');
	}

	public function testPushException2() {
		$datalayer = new DataLayer();

		$this->setExpectedException('InvalidArgumentException');

		$datalayer->push(new \stdClass());
	}

	public function testPop() {
		$datalayer = new DataLayer();

		$datalayer->push(['name' => 'foo']);
		$datalayer->push(['name' => 'bar']);
		$datalayer->push(['name' => 'baz']);

		$this->assertFalse($datalayer->isEmpty());

		$message = $datalayer->pop();
		$this->assertEquals('baz', $message['name']);

		$this->assertFalse($datalayer->isEmpty());

		$message = $datalayer->pop();
		$this->assertEquals('bar', $message['name']);

		$this->assertFalse($datalayer->isEmpty());

		$message = $datalayer->pop();
		$this->assertEquals('foo', $message['name']);

		$this->assertTrue($datalayer->isEmpty());
	}

	public function testPopException1() {
		$datalayer = new DataLayer();

		$this->assertTrue($datalayer->isEmpty());

		$this->setExpectedException('OutOfBoundsException');

		$datalayer->pop();
	}

	public function testShift() {
		$datalayer = new DataLayer();

		$datalayer->unshift(['name' => 'foo']);
		$datalayer->unshift(['name' => 'bar']);
		$datalayer->unshift(['name' => 'baz']);

		$this->assertFalse($datalayer->isEmpty());

		$message = $datalayer->shift();
		$this->assertEquals('baz', $message['name']);

		$this->assertFalse($datalayer->isEmpty());

		$message = $datalayer->shift();
		$this->assertEquals('bar', $message['name']);

		$this->assertFalse($datalayer->isEmpty());

		$message = $datalayer->shift();
		$this->assertEquals('foo', $message['name']);

		$this->assertTrue($datalayer->isEmpty());
	}

	public function testShiftException1() {
		$datalayer = new DataLayer();

		$this->assertTrue($datalayer->isEmpty());

		$this->setExpectedException('OutOfBoundsException');

		$datalayer->shift();
	}

	public function testUnshift() {
		$datalayer = new DataLayer();

		$message = new Message([
			'hello' => 'world',
			'foo'   => [
				'bar',
				'baz'
			]
		]);

		$datalayer->unshift($message);

		$this->assertEquals([$message->send()], $datalayer->send());
	}
}
