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
            'form' => $form->createView(),
            'notification' => ''
        )
    );
});

$app->post('/', function (Request $request) use ($app) {

    $error = '';
    $form = $app['form.factory']->createBuilder('form')
        ->add('FileUpload', 'file')
        ->getForm();

    $form->bind($app['request']);

    if ($form->isValid())
    {
        $files = $request->files->get($form->getName());
        $filename = $files['FileUpload']->getClientOriginalName();

        //TODO We will add this check in validator yml in the future
        // http://symfony.com/doc/current/book/validation.html
        if(!$app['unified']->checkMimetypes($files['FileUpload']->getClientMimeType())) {
            $error = 'Please upload a valid video file';
        } else {
            $files['FileUpload']->move($app['upload_dir'], $filename);
            $zipFile = $app['unified']->getZipArchive($app['upload_dir']);

            return new Response(file_get_contents($zipFile), 200, $headers);
        }
    }

    return $app['twig']->render('index.html.twig', array(
            'message' => 'Upload a file',
            'form' => $form->createView(),
            'notification' => $error
        )
    );
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
