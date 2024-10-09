<?php
/**
 * Plugin Name: ToDo
 * Version:     1.0.0
 * Author:      Li Ying
 */

// Prevent direct access
if ( !defined('ABSPATH') ) {
    exit;
}

define( 'TODO__PLUGIN_STARTPOINT', __FILE__ );
define( 'TODO__PLUGIN_DIR', plugin_dir_path( __FILE__) );
define( 'TODO__PLUGIN_DIR_URL', plugin_dir_url( __FILE__) );

require_once TODO__PLUGIN_DIR . 'autoloader.php';

use ToDoPlugin\Loader;
use ToDoPlugin\AjaxHandler;

Loader::init();
AjaxHandler::listen();
