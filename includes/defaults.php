<?php

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
 * @version     $Id: defaults.php,v 0.0.1 06.01.2016 09:56:04 mitopp Exp $;
 */
if ( ! defined( 'ABSPATH' ) )
    define( 'ABSPATH', dirname( dirname( __FILE__ ) ) );
/**
 * Debugging
 */
if ( ! defined( 'DEBUG' ) )
    define( 'DEBUG', true );
if ( ! defined( 'DEBUG_DISPLAY' ) )
    define( 'DEBUG_DISPLAY', false );
if ( ! defined( 'DEBUG_DETAILS' ) )
    define( 'DEBUG_DETAILS', false );
if ( ! defined( 'DEBUG_LOG' ) )
    define( 'DEBUG_LOG', true );
if ( ! defined( 'DEBUG_LOG_FILE' ) )
    define( 'DEBUG_LOG_FILE', ABSPATH . '/public/debug.log' );
/**
 * Requirements
 */
define( 'REQUIRED_PHP_VERSION', '5.4' );
/**
 * Sessions
 */
if ( ! defined( 'SESSION_SAVE_PATH' ) )
    define( 'SESSION_SAVE_PATH', ABSPATH . '/temp/sessions' );
if ( ! defined( 'SESSION_GC_PROB' ) )
    define( 'SESSION_GC_PROB', 1 );
if ( ! defined( 'SESSION_GC_DIV' ) )
    define( 'SESSION_GC_DIV', 100 );
if ( ! defined( 'SESSION_MAX_LIFETIME' ) )
    define( 'SESSION_MAX_LIFETIME', 1440 );
/**
 * Others
 */
$timers = array();
