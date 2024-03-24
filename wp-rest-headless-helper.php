<?php
/**
 * Plugin Name: WP Rest Headless Helper
 * Plugin URI: https://www.michelecapicchioni.com/
 * Description: This is a helper plugin for WP Rest API in a headless WordPress setup.
 * Version: 1.0.0
 * Author: Michele Capicchioni
 * Author URI: https://www.michelecapicchioni.com/
 * License: GPL2
 */

// Prevent direct file access
defined('ABSPATH') or die('No script kiddies please!');

require_once __DIR__ . '/vendor/autoload.php';

// list classes in src/Module ending in 'Module.php'
$moduleClasses = glob(__DIR__ . '/src/Module/*Module.php');

$moduleInstances = [];
// create an instance of each class
foreach ($moduleClasses as $moduleClass) {
    $moduleClass = str_replace('.php', '', $moduleClass);
    $moduleClass = str_replace(__DIR__ . '/src/Module/', '', $moduleClass);
    $moduleClass = 'Capimichi\\WpRestHeadlessHelper\\Module\\' . $moduleClass;
    $instance = new $moduleClass();
    $moduleInstances[] = $instance;
}

// sort module instances by sort order
usort($moduleInstances, function ($a, $b) {
    return $a->getSort() > $b->getSort() ? 1 : -1;
});

// initialize each module
foreach ($moduleInstances as $moduleInstance) {
    $moduleInstance->initModule();
}