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
