<?php

use Symfony\Component\Process\Process;


class UnifiedService
{
    //TODO this will be in a separate file
    const LICENSE = "license_key";

    public static $mimetypes = array(
        'video/mp4'
    );

    public function executeProcess($command) {
        //This will be a background process in the future
        //with a redis queue
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    public function createFragmentedFile($path)
    {
        //TODO this is for the demo, we will configure the command and options
        return $this->executeProcess(
            sprintf('mp4split --license-key=%1$s -o %2$s/demo.ismv %2$s/demo.mp4', self::LICENSE, $path)
        );
    }

    public function generateServerManifest($path)
    {
        //TODO this is for the demo, we will configure the command and options
        return $this->executeProcess(
            sprintf('mp4split --license-key=%s -o %2$s/demo.ism %2$s/demo.ismv', self::LICENSE, $path)
        );
    }

    public function getZipArchive($path)
    {
        //TODO this is for the demo, we will configure the method and options
        $this->createFragmentedFile($path);
        $this->generateServerManifest($path);

        $zip = new ZipArchive();
        $filename = "$path/demo.zip";

        if($zip->open($filename, ZipArchive::CREATE) !== true) {
            exit("cannot open <$filename>\n");
        }

        $zip->addFile("$path/demo.ism", 'demo.ism');
        $zip->addFile("$path/demo.ismv", 'demo.ismv');
        $zip->close();

        return $zip;
    }

    public function checkMimetypes($mimetype)
    {
        return in_array($mimetype, self::$mimetypes);
    }
}
