<?php

namespace ShineUnited\TagManager\Message\UniversalAnalytics\EnhancedEcommerce;

use ShineUnited\TagManager\Message\UniversalAnalytics\EnhancedEcommerce\EnhancedEcommerceEventMessage;
use ShineUnited\TagManager\Message\UniversalAnalytics\EnhancedEcommerce\ProductFieldMessage;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CheckoutEventMessage extends EnhancedEcommerceEventMessage {

	public function __construct(array $data = []) {
		$resolver = new OptionsResolver();
		$resolver->setRequired(['step', 'option']);
		$resolver->setOptional(['products']);
		$resolver->setAllowedTypes([
			'step'     => ['string', 'numeric'],
			'option'   => 'string',
			'products' => 'array'
		]);
		$resolver->setDefaults([
			'products' => []
		]);
		$data = $resolver->resolve($data);

		parent::__construct([
			'event' => 'checkout',
			'ecommerce' => [
				'actionField' => [
					'step' => $data['step'],
					'option' => $data['option']
				],
				'products' => $data['products']
			]
		]);
	}

	public function addProduct($product = []) {
		if(!$product instanceof ProductFieldMessage) {
			$product = new ProductFieldMessage($product);
		}

		$this['products'][] = $product;
	}
}
