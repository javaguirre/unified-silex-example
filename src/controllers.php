<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


$app->get('/', function (Request $request) use ($app) {

    $form = $app['form.factory']->createBuilder('form')
        ->add('FileUpload', 'file')
        ->getForm();

    return $app['twig']->render('index.html.twig', array(
            'message' => 'Upload a file',
            'form' => $form->createView()
        )
    );
});

$app->post('/', function (Request $request) use ($app) {

    $form = $app['form.factory']->createBuilder('form')
        ->add('FileUpload', 'file')
        ->getForm();

    $form->bind($app['request']);

    if ($form->isValid())
    {
        $files = $request->files->get($form->getName());
        $filename = $files['FileUpload']->getClientOriginalName();

        $files['FileUpload']->move($app['upload_dir'], $filename);

        $zipFile = $app['unified']->getZipArchive($path);

        return new Response(file_get_contents($zipFile), 200, $headers);
    }

    //TODO
    return new Response();
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});
