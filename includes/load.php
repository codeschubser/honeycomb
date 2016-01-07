<?php

use de\codeschubser\honeycomb\core\controllers\Autoload,
    de\codeschubser\honeycomb\core\controllers\Error,
    de\codeschubser\honeycomb\core\models\Session,
    de\codeschubser\honeycomb\core\models\I18N;

/**
 * The MIT License
 *
 * Copyright 2016 Codeschubser.de
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category    Honeycomb | Groupware
 * @package     Includes
 * @author      Michael Topp <blog@codeschubser.de>
 * @copyright   Copyright (c), 2016 Codeschubser.de
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version     $Id: load.php,v 0.0.1 06.01.2016 09:56:49 mitopp Exp $;
 */
if ( ! defined( 'ABSPATH' ) )
    define( 'ABSPATH', dirname( dirname( __FILE__ ) ) );
/**
 * Default error reporting
 */
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
/**
 * Load the main configuration
 */
if ( file_exists( ABSPATH . '/config.php' ) ) {
    require_once( ABSPATH . '/config.php' );
}
/**
 * Load defaults, compatibility and helpful standalone functions
 */
require_once( ABSPATH . '/includes/defaults.php' );
require_once( ABSPATH . '/includes/compat.php' );
require_once( ABSPATH . '/includes/functions.php' );
/**
 * Check requirements or die are not met.
 */
check_requirements();
/**
 * Debug mode initialization
 */
debug_mode();
/**
 * Enqueue autoloader
 */
require_once( ABSPATH . '/core/controllers/Autoload.php' );
$loader = new Autoload();
$loader->register();
$loader->addNamespace( 'de\codeschubser\honeycomb\core\controllers', ABSPATH . '/core/controllers' );
$loader->addNamespace( 'de\codeschubser\honeycomb\core\exceptions', ABSPATH . '/core/exceptions' );
$loader->addNamespace( 'de\codeschubser\honeycomb\core\models', ABSPATH . '/core/models' );
$loader->addNamespace( 'de\codeschubser\honeycomb\core\vendors', ABSPATH . '/core/vendors' );
$loader->addNamespace( 'de\codeschubser\honeycomb\core\views', ABSPATH . '/core/views' );
/**
 * Start global timer
 */
timer_start();
/**
 * Start error handler
 */
new Error();
/**
 * Start session handling
 */
new Session();
/**
 * Initiate Internationalization
 */
I18N::setLocale();
/**
 * Set system timezone
 */
date_default_timezone_set( TIMEZONE );
