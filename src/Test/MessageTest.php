<?php

namespace ShineUnited\TagManager\Test;

use ShineUnited\TagManager\Message;


class MessageTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$message = new Message([
			'a' => 'value-1',
			'b' => 'value-2',
			'c' => [
				'c1' => 'value-3',
				'c2' => 'value-4'
			]
		]);

		$this->assertTrue(isset($message['a']));
		$this->assertTrue(isset($message['b']));
		$this->assertTrue(isset($message['c']));
		$this->assertFalse(isset($message['d']));
		$this->assertTrue(isset($message['c']['c1']));
		$this->assertTrue(isset($message['c']['c2']));
		$this->assertFalse(isset($message['c']['c3']));
		$this->assertEquals('value-1', $message['a']);
		$this->assertEquals('value-2', $message['b']);
		$this->assertInstanceOf('ShineUnited\TagManager\Message', $message['c']);
		$this->assertEquals('value-3', $message['c']['c1']);
		$this->assertEquals('value-4', $message['c']['c2']);
	}

	public function testSet() {
		$message = new Message();

		$this->assertFalse(isset($message['a']));

		$message['a'] = 'value-1';

		$this->assertTrue(isset($message['a']));
		$this->assertEquals('value-1', $message['a']);

		$message['a'] = 'value-2';

		$this->assertEquals('value-2', $message['a']);
	}

	public function testUnset() {
		$message = new Message();

		$this->assertFalse(isset($message['a']));

		unset($message['a']);
		$this->assertFalse(isset($message['a']));

		$message['a'] = 'value-1';
		$this->assertTrue(isset($message['a']));

		unset($message['a']);
		$this->assertFalse(isset($message['a']));
	}
}
