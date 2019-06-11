<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_NOTICE);

//include ( __DIR__ . '/33.phar');
//eval(str_replace('<' . '?php', '', file_get_contents('phar://' . __DIR__ . '/33.phar/index.php')));
//include ('phar://' . __DIR__ . '/33.phar/test.php');


function am_require_once($path, $require = true)
{
    if (!defined('AM_PHAR_WORKAROUND'))
    {
        define('AM_PHAR_WORKAROUND',
            extension_loaded('Zend OPcache')
            && ini_get('opcache.enable')
            && ini_get('opcache.validate_permission'));
    }
    if (
        (defined('AM_PHAR_WORKAROUND') && !AM_PHAR_WORKAROUND)
        || !preg_match($x = '#^phar://(.+\.phar)(.+)$#', $path, $match)) //\/\/([a-zA-Z0-9_-]+\.phar)(.+)
    {
        return $require ? require_once $path : include_once $path;
    }
    list($_, $pharPath, $incPath) = $match;
    $alias = basename($pharPath, '.phar') . '_' . md5($pharPath);

    static $pharLoaded = [];
    if (empty($pharLoaded[$alias]))
    {
        if (!Phar::loadPhar($pharPath, $alias))
        {
            return false;
        }
        $pharLoaded[$alias] = true;
    }

    $newPath = "phar://{$alias}{$incPath}";
    return $require ? require_once $newPath : include_once $newPath;
}

function am_include_once($path)
{
    return am_require_once($path, false);
}

am_include_once('phar://'.__DIR__ . '/33.phar'.'/test.php');
am_require_once('phar://'.__DIR__ . '/33.phar'.'/index.php');
am_include_once('phar://'.__DIR__ . '/33.phar'.'/test.php');


//$st = opcache_get_status(true);
//var_dump($st['scripts']);

