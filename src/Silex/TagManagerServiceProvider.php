<?php

namespace ShineUnited\TagManager\Silex;

use ShineUnited\TagManager\Container;
use ShineUnited\TagManager\DataLayer;
use ShineUnited\TagManager\Twig\TagManagerExtension;
use Pimple\Container AS PimpleContainer;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;


class TagManagerServiceProvider implements ServiceProviderInterface, BootableProviderInterface {

	public function register(PimpleContainer $app) {
		$app['gtm.config'] = function() use ($app) {
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
		};

		$app['gtm.container'] = function() use ($app) {
			return new Container(
				$app['gtm.config']['id'],
				$app['gtm.datalayer']
			);
		};

		$app['gtm.datalayer'] = function() use ($app) {
			if($app['gtm.config']['persist'] && isset($app['session'])) {
				if(!$app['session']->has($app['gtm.config']['varname'])) {
					$app['session']->set($app['gtm.config']['varname'], new DataLayer());
				}

				return $app['session']->get($app['gtm.config']['varname']);
			}

			return new DataLayer();
		};
	}

	public function boot(Application $app) {
		// extend twig if present
		if(isset($app['twig'])) {
			$app['twig'] = $app->extend('twig', function($twig, $app) {
				$twig->addExtension(new TagManagerExtension($app['gtm.container']));

				return $twig;
			});
		}
	}
}
