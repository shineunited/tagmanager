<?php

namespace ShineUnited\TagManager;

use ShineUnited\TagManager\DataLayer;


class Container {
	private $id;
	private $datalayer;

	public function __construct($id, DataLayer $datalayer = null) {
		$this->id = $id;

		if($datalayer) {
			$this->setDataLayer($datalayer);
		} else {
			$this->setDataLayer(new DataLayer());
		}
	}

	public function getId() {
		return $this->id;
	}

	public function getDataLayer() {
		return $this->datalayer;
	}

	public function setDataLayer(DataLayer $datalayer) {
		$this->datalayer = $datalayer;
	}

	public function __call($name, array $params = []) {
		if(method_exists($this->datalayer, $name)) {
			return call_user_func_array([$this->datalayer, $name], $params);
		}

		throw new \BadMethodCallException('unknown method: ' . $name);
	}

	public function __get($name) {
		$getter = 'get' . $name;
		if(method_exists($this, $getter)) {
			return call_user_func([$this, $getter]);
		}

		throw new \InvalidArgumentException('unable to get property value: ' . $name);
	}

	public function __set($name, $value) {
		$setter = 'set' . $name;
		if(method_exists($this, $setter)) {
			return call_user_func([$this, $setter], $value);
		}

		throw new \InvalidArgumentException('unable to set property value: ' . $name);
	}

	public function render($mode = 'all') {
		$mode = strtolower(trim($mode));

		$output = '';

		if(!is_string($this->id)) {
			return '';
		}

		if($mode == 'all' || $mode == 'head') {
			// render datalayer
			$output .= $this->dataLayer->render();

			// render head block
			$template = file_get_contents(__DIR__ . '/Resources/head.html');
			$output .= str_replace('%GTMID%', $this->getId(), $template);
		}

		if($mode == 'all' || $mode == 'body') {
			// render body block
			$template = file_get_contents(__DIR__ . '/Resources/body.html');
			$output .= str_replace('%GTMID%', $this->getId(), $template);
		}

		return $output;
	}
}
