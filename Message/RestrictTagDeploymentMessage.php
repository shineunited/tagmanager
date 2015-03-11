<?php

namespace ShineUnited\TagManager\Message;

use ShineUnited\TagManager\Message;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RestrictTagDeploymentMessage extends Message {

	public function __construct(array $data = []) {
		$resolver = new OptionsResolver();
		$resolver->setOptional(['gtm.whitelist', 'gtm.blacklist']);
		$resolver->setAllowedTypes([
			'gtm.whitelist' => 'array',
			'gtm.blacklist' => 'array'
		]);

		$data = $resolver->resolve($data);

		parent::__construct($data);
	}

	public function addToWhitelist($id) {
		$this['gtm.whitelist'][] = $id;
	}

	public function addToBlacklist($id) {
		$this['gtm.blacklist'][] = $id;
	}
}
