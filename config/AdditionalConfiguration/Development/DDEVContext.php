<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '.*';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'] = [
    'charset' => 'utf8',
    'dbname' => 'db',
    'host' => 'db',
    'password' => 'db',
    'port' => 3306,
    'user' => 'db',
    'driver' => 'mysqli',
];
