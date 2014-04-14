<?php

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;

$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());

$app->register(new TwigServiceProvider(), array(
    'twig.path' => array(__DIR__.'/templates'),
    'twig.options' => array('cache' => __DIR__.'/../cache/templates'),
));

$app['upload_dir'] = __DIR__ . '/../web/upload/';

$app['unified'] = function () {
    return new UnifiedService();
};

$app['debug'] = true;

return $app;
