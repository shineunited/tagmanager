<?php

namespace ShineUnited\TagManager\Tests;

use ShineUnited\TagManager\Container;


class ContainerTest extends DataLayerTest {

	public function testRender() {
		$id = 'GTM-XXX';

		$container = new Container($id);

		$expected = '';

		$headTemplate = file_get_contents(__DIR__ . '/../src/Resources/head.html');
		$bodyTemplate = file_get_contents(__DIR__ . '/../src/Resources/body.html');

		$expected .= str_replace('%GTMID%', $id, $headTemplate);
		$expected .= str_replace('%GTMID%', $id, $bodyTemplate);

		$this->assertEquals($expected, $container->render());
	}

	public function testRenderHead() {
		$id = 'GTM-XXX';

		$container = new Container($id);

		$expected = '';

		$headTemplate = file_get_contents(__DIR__ . '/../src/Resources/head.html');

		$expected .= str_replace('%GTMID%', $id, $headTemplate);

		$this->assertEquals($expected, $container->render('head'));
	}

	public function testRenderBody() {
		$id = 'GTM-XXX';

		$container = new Container($id);

		$expected = '';

		$bodyTemplate = file_get_contents(__DIR__ . '/../src/Resources/body.html');

		$expected .= str_replace('%GTMID%', $id, $bodyTemplate);

		$this->assertEquals($expected, $container->render('body'));
	}
}
