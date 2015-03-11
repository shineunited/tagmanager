<?php

namespace ShineUnited\TagManager\Message\UniversalAnalytics\EnhancedEcommerce;

use ShineUnited\TagManager\Message\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;


class EnhancedEcommerceMessage extends Message {

	public function __construct(array $data = []) {
		$resolver = new OptionsResolver();
		$resolver->setRequired(['ecommerce']);
		$resolver->setOptional(['event']);
		$resolver->setAllowedTypes([
			'event'     => 'string',
			'ecommerce' => 'array'
		]);
		$data = $resolver->resolve($data);

		parent::__construct($data);
	}
}
