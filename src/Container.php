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

	public function render($preview = false) {
		$output = '';

		if(!is_string($this->id)) {
			return '';
		}

		if(!$this->datalayer->isEmpty()) {
			$output .= '<script>dataLayer = ' . json_encode($this->datalayer->send($preview)) . ';</script>';
		}

		$output .=  <<<CONTAINER
<!-- Google Tag Manager: Container -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id={$this->id}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$this->id}');</script>
<!-- End Google Tag Manager: Container -->
CONTAINER;

		return $output;
	}
}
