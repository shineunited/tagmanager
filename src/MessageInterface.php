<?php

namespace ShineUnited\TagManager;


interface MessageInterface extends \ArrayAccess, \Traversable, \Serializable {

	/**
	 * @param array $params The custom option values.
	 *
	 * @return array A list of params and their values.
	 *
	 * @throws InvalidArgumentException If any errors occur while creating the message
	 */
	public function __construct(array $data = []);

	public function isEmpty();

	public function send($preview = false);
}
