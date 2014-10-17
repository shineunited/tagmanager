<?php

namespace ShineUnited\TagManager\Test\Silex;

use ShineUnited\TagManager\Silex\TagManagerServiceProvider;
use Silex\Application;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;


class TagManagerServiceProviderTest extends \PHPUnit_Framework_TestCase {



	public function testRegister() {
		$app = new Application();

		$app->register(new TagManagerServiceProvider(), [
			'gtm.id' => 'GTM-XXX'
		]);

		$request = Request::create('/');
		$app->handle($request);

		$this->assertInstanceOf('ShineUnited\TagManager\Container', $app['gtm.container']);

		$this->assertInstanceOf('ShineUnited\TagManager\DataLayer', $app['gtm.datalayer']);

		$this->assertEquals($app['gtm.container']->getId(), 'GTM-XXX');
	}

	public function testSessionStorage() {
		$app = new Application();

		$app->register(new SessionServiceProvider(), [
			'session.test' => true
		]);

		$app->register(new TagManagerServiceProvider(), [
			'gtm.options' => [
				'id' => 'GTM-XXX'
			]
		]);

		$request = Request::create('/');
		$app->handle($request);

		$this->assertInstanceOf('ShineUnited\TagManager\Container', $app['gtm.container']);

		$this->assertInstanceOf('ShineUnited\TagManager\DataLayer', $app['gtm.datalayer']);

	}

	/*
	public function testRegisterWithTwig() {
		$app = new Application();

		$app->register(new TwigServiceProvider());

		$app->register(new TagManagerServiceProvider(), [
			'gtm.options' => [
				'id' => 'GTM-XXX'
			]
		]);

		$request = Request::create('/');
		$app->handle($request);

		$this->assertInstanceOf('ShineUnited\TagManager\Container', $app['gtm.container']);

		$this->assertInstanceOf('ShineUnited\TagManager\DataLayer', $app['gtm.datalayer']);
	}

	public function testRegisterWithSession() {
		$app = new Application();

		$app->register(new SessionServiceProvider(), [
			'session.test' => true
		]);

		$app->register(new TagManagerServiceProvider(), [
			'gtm.options' => [
				'id' => 'GTM-XXX'
			]
		]);

		$request = Request::create('/');
		$app->handle($request);

		$this->assertInstanceOf('ShineUnited\TagManager\Container', $app['gtm.container']);

		$this->assertInstanceOf('ShineUnited\TagManager\DataLayer', $app['gtm.datalayer']);
	}
	*/
}
