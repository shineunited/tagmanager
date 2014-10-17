<?php

namespace ShineUnited\TagManager;

use ShineUnited\TagManager\MessageInterface;


class Message implements \IteratorAggregate, MessageInterface {
	private $data;
	private $sent;

	public function __construct(array $data = []) {
		$this->data = [];
		$this->sent = false;

		foreach($data as $offset => $value) {
			$this->offsetSet($offset, $value);
		}
	}

	public function send($preview = false) {
		$output = [];
		foreach($this->data as $offset => $value) {
			if($value instanceof MessageInterface) {
				if(!$value->isEmpty()) {
					$output[$offset] = $value->send($preview);
				}
			} else {
				$output[$offset] = $value;
			}
		}

		if(!$preview) {
			$this->sent = true;
		}

		return $output;
	}

	public function isEmpty() {
		if(count($this->data) > 0) {
			return false;
		}

		return true;
	}

	public function serialize() {
		return serialize($this->data);
	}

	public function unserialize($data) {
		$this->data = unserialize($data);
	}

	public function offsetExists($offset) {
		if(isset($this->data[$offset])) {
			return true;
		}

		return false;
	}

	public function offsetGet($offset) {
		if(isset($this->data[$offset])) {
			return $this->data[$offset];
		}

		return $this->data[$offset] = new Message();
	}

	public function offsetSet($offset, $value) {
		if($this->sent) {
			throw new \RuntimeException('unable to modify sent message');
		}

		if(!is_scalar($value) && !is_array($value) && !$value instanceof MessageInterface) {
			throw new \InvalidArgumentException('invalid value type: ' . gettype($value));
		}

		if(is_array($value)) {
			$value = new Message($value);
		}

		if($offset) {
			return $this->data[$offset] = $value;
		} else {
			return $this->data[] = $value;
		}
	}

	public function offsetUnset($offset) {
		if($this->sent) {
			throw new \RuntimeException('unable to modify sent message');
		}

		if(isset($this->data[$offset])) {
			unset($this->data[$offset]);
		}
	}

	public function getIterator() {
		return new \ArrayIterator($this->data);
	}
}
