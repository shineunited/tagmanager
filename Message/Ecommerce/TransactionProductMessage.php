<?php

namespace ShineUnited\TagManager\Message\UniversalAnalytics;

use ShineUnited\TagManager\Message\Message;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EcommerceTransactionProductMessage extends Message {

	protected function buildMessage(array $data = []) {
		$resolver = new OptionsResolver();
		$resolver->setRequired(['name', 'sku', 'price', 'quantity']);
		$resolver->setOptional(['category']);
		$resolver->setAllowedTypes([
			'name'     => 'string',
			'sku'      => 'string',
			'category' => 'string',
			'price'    => 'numeric',
			'quantity' => 'numeric'
		]);

		$data = $resolver->resolve($data);

		return parent::buildMessage($data);
	}
}
