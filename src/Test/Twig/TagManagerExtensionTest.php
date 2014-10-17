<?php

namespace ShineUnited\TagManager\Test\Twig;

use ShineUnited\TagManager\Twig\TagManagerExtension;


class TagManagerExtensionTest extends \PHPUnit_Framework_TestCase {

	public function testRenderContainer() {

		$response = $this->renderTemplate('test');

		$this->assertEquals('test', $response);
	}


	protected function renderTemplate($output, $template = '{{ gtm() }}') {
		$container = $this->getMockBuilder('ShineUnited\TagManager\Container')
			->disableOriginalConstructor()
			->getMock()
		;

		$container->method('render')->willReturn($output);

		$loader = new \Twig_Loader_Array(array('index' => $template));
        $twig = new \Twig_Environment($loader, array('debug' => true, 'cache' => false));
		$twig->addExtension(new TagManagerExtension($container));

		return $twig->render('index');
	}
}
