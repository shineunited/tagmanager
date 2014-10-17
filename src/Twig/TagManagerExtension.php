<?php

namespace ShineUnited\TagManager\Twig;

use ShineUnited\TagManager\Container;


class TagManagerExtension extends \Twig_Extension {
	private $container;

	public function __construct(Container $container) {
		$this->container = $container;
	}

	public function getFunctions() {
		return array(
			new \Twig_SimpleFunction('gtm', array($this->container, 'render'), array(
				'is_safe' => array('html')
			))
		);
	}

	public function getName() {
		return 'gtm';
	}
}
