<?php

namespace ShineUnited\TagManager;

use ShineUnited\TagManager\Message;
use ShineUnited\TagManager\MessageInterface;


class DataLayer {
	private $messages;

	public function __construct() {
		$this->messages = array();
	}

	public function isEmpty() {
		foreach($this->messages as $message) {
			if(!$message->isEmpty()) {
				return false;
			}
		}

		return true;
	}

	public function message($message = []) {
		if(is_array($message)) {
			return new Message($message);
		}

		if($message instanceof MessageInterface) {
			return $message;
		}

		throw new \InvalidArgumentException('invalid message type (' . gettype($message) . ')');
	}

	public function push($data = []) {
		$message = $this->message($data);
		array_push($this->messages, $message);
		return $message;
	}

	public function pop() {
		if($this->isEmpty()) {
			throw new \OutOfBoundsException('datalayer is empty');
		}

	 	$message = array_pop($this->messages);
		return $message;
	}

	public function unshift($data = []) {
		$message = $this->message($data);
		array_unshift($this->messages, $message);
		return $message;
	}

	public function shift() {
		if($this->isEmpty()) {
			throw new \OutOfBoundsException('datalayer is empty');
		}

		$message = array_shift($this->messages);
		return $message;
	}

	public function enqueue($data = []) {
		return $this->push($data);
	}

	public function dequeue() {
		return $this->shift();
	}

	public function send($preview = false) {
		$output = [];
		foreach($this->messages as $message) {
			$output[] = $message->send($preview);
		}

		if(!$preview) {
			$this->messages = [];
		}

		return $output;
	}
}
