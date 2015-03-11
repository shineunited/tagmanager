<?php

namespace ShineUnited\TagManager\Message\UniversalAnalytics;

use ShineUnited\TagManager\Message\Message;
use ShineUnited\TagManager\Message\UniversalAnalytics\EcommerceTransactionProductMessage;

use Symfony\Component\OptionsResolver\OptionsResolver;


class EcommerceTransactionMessage extends Message {

	protected function buildMessage(array $data = []) {
		$resolver = new OptionsResolver();
		$resolver->setRequired(['id', 'total']);
		$resolver->setOptional(['affiliation', 'shipping', 'tax', 'products']);
		$resolver->setAllowedTypes([
			'id'          => 'string',
			'affiliation' => 'string',
			'total'       => 'numeric',
			'shipping'    => 'numeric',
			'tax'         => 'numeric',
			'products'    => 'array'
		]);
		$data = $resolver->resolve($data);

		foreach($data as $key => $value) {
			$label = 'transaction' . ucfirst($key);
			$this[$label] = $value;
		}
	}

	public function addProduct($product = []) {
		if($product instanceof Message) {
			return $this['transactionProducts'][] = $product;
		}

		return $this['transactionProducts'][] = new EcommerceTransactionProductMessage($product);
	}
}

class EcommerceTransactionProduct extends Message {

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
