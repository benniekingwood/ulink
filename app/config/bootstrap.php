<?php

/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
App::import('Core', array('Dispatcher', 'Debugger'));

// custom functions
function prd($var) {
    pr($var);
    die;
}

// defined vars
// theulink.com GOOGLE_MAP_API_KEY - 'ABQIAAAAJZHppX6qQ2j8YZe0T5gGYRQV8rZfp7KNipKKWaBNmcOh9zalzBS98OtvEZAOD4PDe7YWyLzhtSNyGw'
if (!defined('GOOGLE_MAP_API_KEY')) {
    define('GOOGLE_MAP_API_KEY', 'ABQIAAAAJZHppX6qQ2j8YZe0T5gGYRQV8rZfp7KNipKKWaBNmcOh9zalzBS98OtvEZAOD4PDe7YWyLzhtSNyGw');
}
if (!defined('SERVER_NAME')) {
    define('SERVER_NAME', $_SERVER['SERVER_NAME']);
}
if (!defined('DEFAULT_URL')) {
    define('DEFAULT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/');
}
if (!defined('ZEND_LIB_DIR')) {
    define('ZEND_LIB_DIR', '/app/webroot/ulink-youtube/library/');
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/app/webroot/img/editorfiles/');
}
if (!defined('FACEBOOK_APP_ID')) {
    define('FACEBOOK_APP_ID', '243782652334409');
}
if (!defined('FACEBOOK_APP_URL')) {
    define('FACEBOOK_APP_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/app/webroot/xd_receiver.htm');
}
if (!defined('FACEBOOK_APP_SECRET')) {
    define('FACEBOOK_APP_SECRET', 'c50f97cbd574f6f67234a34da3265dba');
}

if (!defined('YOUTUBE_DEV_KEY')) {
    define('YOUTUBE_DEV_KEY', 'AI39si6454XolD2jv7ALSa3vC-hlxP6sH2YGTtqvUpPhHNdWm98yTYXmu_8WepCMetnTHOI9O9OXSCnPX9KZn8NLpeMBkt0eRQ');
}

if (!defined('YOUTUBE_USERNAME')) {
    define('YOUTUBE_USERNAME', 'bennie.ulink@gmail.com');
}
if (!defined('YOUTUBE_PASSWORD')) {
    define('YOUTUBE_PASSWORD', 'uLink1983');
}

if (!defined('RECENT_REVIEWS_TITLE')) {
    define('RECENT_REVIEWS_TITLE', 'uLink - Recent Reviews');
}

if (!defined('NEWLY_ADDED_SCHOOL')) {
    define('NEWLY_ADDED_SCHOOL', 'uLink - Newly Added Schools');
}

if (!defined('TOP_RATED_SCHOOLS')) {
    define('TOP_RATED_SCHOOLS', 'uLink - Top Rated Schools');
}

if (!defined('SUGGEST_A_SCHOOL')) {
    define('SUGGEST_A_SCHOOL', 'uLink - Suggest a School');
}

if (!defined('IPINFODB_KEY')) {
    define('IPINFODB_KEY', '361b0020ff924f4fbb90c25b9b3f07a604a89e9c0b0aa8bc304d1192bb26e96f');
}
?>