<?php

namespace ShineUnited\TagManager\Silex;

use ShineUnited\TagManager\Container;
use ShineUnited\TagManager\DataLayer;
use ShineUnited\TagManager\Twig\TagManagerExtension;
use Silex\Application;
use Silex\ServiceProviderInterface;


class TagManagerServiceProvider implements ServiceProviderInterface {

	public function register(Application $app) {

		$app['gtm.config'] = $app->share(function() use ($app) {
			$config = [];

			// id
			if(isset($app['gtm.options']) && isset($app['gtm.options']['id'])) {
				$config['id'] = $app['gtm.options']['id'];
			} elseif(isset($app['gtm.id'])) {
				$config['id'] = $app['gtm.id'];
			}

			// persist
			if(isset($app['gtm.options']) && isset($app['gtm.options']['persist'])) {
				$config['persist'] = $app['gtm.options']['persist'];
			} elseif(isset($app['gtm.persist'])) {
				$config['persist'] = $app['gtm.persist'];
			} else {
				$config['persist'] = true;
			}

			// varname
			if(isset($app['gtm.options']) && isset($app['gtm.options']['varname'])) {
				$config['varname'] = $app['gtm.options']['varname'];
			} elseif(isset($app['gtm.varname'])) {
				$config['varname'] = $app['gtm.varname'];
			} else {
				$config['varname'] = 'gtm';
			}

			return $config;
		});

		$app['gtm.container'] = $app->share(function() use ($app) {
			return new Container(
				$app['gtm.config']['id'],
				$app['gtm.datalayer']
			);
		});

		$app['gtm.datalayer'] = $app->share(function() use ($app) {
			if($app['gtm.config']['persist'] && isset($app['session'])) {
				if(!$app['session']->has($app['gtm.config']['varname'])) {
					$app['session']->set($app['gtm.config']['varname'], new DataLayer());
				}

				return $app['session']->get($app['gtm.config']['varname']);
			}

			return new DataLayer();
		});

		// extend twig
		if(isset($app['twig'])) {
			$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
				$twig->addExtension(new TagManagerExtension($app['gtm.container']));

				return $twig;
			}));
		}
	}

	public function boot(Application $app) {}
}
