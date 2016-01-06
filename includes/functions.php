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
 * @version     $Id: functions.php,v 0.0.1 06.01.2016 10:07:06 mitopp Exp $;
 */
/**
 * Check for the required PHP version, and the MySQL extension.
 * Dies if requirements are not met.
 *
 * @since   0.0.1
 *
 * @access  private
 * @return  void
 */
function check_requirements()
{
    $php_version = phpversion();

    if ( version_compare( REQUIRED_PHP_VERSION, $php_version, '>' ) ) {
        header( sprintf( '%s 500 Internal Server Error', $_SERVER['SERVER_PROTOCOL'] ), true, 500 );
        header( 'Content-Type: text/html; charset=utf-8' );
        die( sprintf( 'Your server is running PHP version %1$s but Honeycomb %2$s requires at least %3$s.',
                $php_version, '0.0.1', REQUIRED_PHP_VERSION ) );
    }

    if ( ! extension_loaded( 'mysql' ) && ! extension_loaded( 'mysqli' ) && ! extension_loaded( 'pdo' ) ) {
        header( sprintf( '%s 500 Internal Server Error', $_SERVER['SERVER_PROTOCOL'] ), true, 500 );
        header( 'Content-Type: text/html; charset=utf-8' );
        die( 'Your PHP installation appears to be missing the MySQL PDO extension wich is required by Honeycomb.' );
    }
}
/**
 * Starts a micro-timer.
 *
 * @since   0.0.1
 *
 * @see     timer_stop()
 *
 * @access  private
 * @global  array   $timers Array of timers with unix timestamp.
 * @param   string  $name   Optional. Name of the timer. Default: global
 * @return  void
 */
function timer_start( $name = 'global' )
{
    global $timers;
    $timers[$name] = microtime( true );
}
/**
 * Retrieve or display the time from the start to when function is called.
 *
 * @since   0.0.1
 *
 * @see     timer_start(), number_format_i18n()
 *
 * @access  private
 * @global  array   $timers     Array of timers with unix timestamp.
 * @param   string  $name       Optional. Name of the timer. Default: global
 * @param   bool    $display    Optional. Whether to echo or return the results. Default: false
 * @param   int     $precision  Optional. The number of digits from the right of the decimal to display. Default: 3
 * @return  mixed   The "second.microsecond" finished time calculation. The number is formatted for
 *                  human consumption, both localized and rounded. False on failure.
 */
function timer_stop( $name = 'global', $display = false, $precision = 3 )
{
    global $timers;
    if ( array_key_exists( $name, $timers ) ) {
        $timeend = microtime( true );
        $total = $timeend - $timers[$name];
        $output = (function_exists( 'number_format_i18n' )) ? number_format_i18n( $total, $precision ) : number_format( $total,
                $precision );
        if ( $display ) {
            echo $output;
        }

        return $output;
    }

    return false;
}
/**
 * Convert integer number to format based on the locale.
 *
 * @since   0.0.1
 *
 * @access  private
 * @param   int     $number     The number to convert based on locale.
 * @param   int     $decimals   Optional. Precision of the number of decimal places. Default: 0.
 * @return  string  Converted number in string format.
 */
function number_format_i18n( $number, $decimals = 0 )
{
    $locale = localeconv();

    return number_format( $number, abs( intval( $decimals ) ), $locale['decimal_point'],
        $locale['thousands_sep'] );
}
/**
 * Set PHP error reporting based on debug settings.
 *
 * When `DEBUG` is true, all PHP notices are reported. Honeycomb will also
 * display internal notices: when a deprecated Honeycomb function, function
 * argument, or file is used. Deprecated code may be removed from a later version.
 *
 * When `DEBUG_DISPLAY` is true, Honeycomb will force errors to be displayed.
 *
 * When `DEBUG_LOG` is true, errors will be logged to debug.log in the public directory.
 *
 * @since   0.0.1
 *
 * @access  private
 * @return  void
 */
function debug_mode()
{
    if ( DEBUG ) {
        error_reporting( E_ALL );

        if ( DEBUG_DISPLAY ) {
            ini_set( 'display_errors', true );
        } else if ( null !== DEBUG_DISPLAY ) {
            ini_set( 'display_errors', false );
        }

        if ( DEBUG_LOG ) {
            ini_set( 'log_errors', true );
            ini_set( 'error_log', DEBUG_LOG_FILE );
        }
    } else {
        error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
    }
}
