<?php

function buildPhar()
{
    $rootDir = dirname(__DIR__);
    $pharFile =  $rootDir . '/33.phar';

    $files = [ $rootDir . '/build-phar/test.php',  $rootDir . '/build-phar/index.php'];

    if (file_exists($pharFile))
    {
        unlink($pharFile);
    }

    $phar = new Phar($pharFile);
    $phar->setSignatureAlgorithm(Phar::SHA1);
    $phar->startBuffering();
    $stub = $phar->createDefaultStub();

    $f = new AppendIterator;
    $f->append(new ArrayIterator($files));
    $phar->buildFromIterator($f, $rootDir . '/build-phar');
    $phar->setStub($stub);
    // $phar->compressFiles(Phar::GZ);
    $phar->stopBuffering();

    echo "$pharFile build completed\n";
}

buildPhar();