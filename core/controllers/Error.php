<?php

namespace de\codeschubser\honeycomb\core\controllers;

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
 * @package     Core
 * @author      Michael Topp <blog@codeschubser.de>
 * @copyright   Copyright (c), 2016 Codeschubser.de
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version     $Id: Error.php,v 0.0.1 07.01.2016 07:17:51 mitopp Exp $;
 */
class Error
{
    /**
     * Define errors as fatal.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @var     array
     */
    protected $fatal_errors = array( E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR );
    /**
     * Marked a error as fatal.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @var     bool
     */
    protected $is_fatal = false;

    /**
     * CONSTRUCTOR
     * Register error, fatal error and exception handler.
     *
     * @since   0.0.1
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        // Don't show fatal errors from PHP internal error handler
        ini_set( 'display_errors', false );

        set_error_handler( array( $this, 'handleErrors' ) );
        set_exception_handler( array( $this, 'handleExceptions' ) );
        register_shutdown_function( array( $this, 'handleFatalErrors' ) );
    }
    /**
     * Handle all errors.
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   int     $code       Contains the level of the error raised.
     * @param   string  $message    Contains the error message.
     * @param   string  $file       Contains the filename that the error was raised in.
     * @param   int     $line       Contains the line number the error was raised at.
     * @param   mixed   $context    Optional. An array that points to the active symbol table at
     *                              the point the error occurred. An array or a previous exception.
     *                              Default: null
     * @return  bool    Always returns true to disable the PHP internal error handler.
     */
    public function handleErrors( $code, $message, $file, $line, $context = null )
    {
        if ( ! (error_reporting() & $code) ) {
            return;
        }

        $error = null;
        switch ( $code ) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_USER_ERROR:
            case E_COMPILE_ERROR:
            case E_RECOVERABLE_ERROR:
                if ( $this->is_fatal ) {
                    $error = 'Fatal ';
                }
                $error .= 'Error';
                break;
            case E_STRICT:
            case E_WARNING:
            case E_CORE_WARNING:
            case E_USER_WARNING:
            case E_COMPILE_WARNING:
                $error = 'Warning';
                break;
            case E_NOTICE:
            case E_DEPRECATED:
            case E_USER_NOTICE:
            case E_USER_DEPRECATED:
                $error = 'Notice';
                break;
            default:
                $error = 'Unknown error';
                break;
        }

        $output = date( 'c' )
            . " ["
            . date_default_timezone_get()
            . "] "
            . $error
            . "(" . $code . "): "
            . $message
            . " in "
            . $file
            . " on line "
            . $line
            . PHP_EOL;

        if ( DEBUG_DETAILS ) {
            $output .= $this->buildErrorDetails();
        }

        if ( DEBUG_DISPLAY ) {
            print $output;
        }

        // Don't execute PHP internal error handler
        return true;
    }
    /**
     * Handle all exceptions.
     *
     * @since   0.0.1
     *
     * @see     handleErrors()
     *
     * @access  public
     * @param   \Exception  $ex The exception object that was thrown.
     * @return  void
     */
    public function handleExceptions( \Exception $ex )
    {
        $this->handleErrors( $ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine(),
            $ex->getPrevious() );
    }
    /**
     * Handle all fatal errors.
     *
     * @since   0.0.1
     *
     * @see     handleErrors(), $fatal_errors
     *
     * @access  public
     * @return  void
     */
    public function handleFatalErrors()
    {
        $last_error = error_get_last();
        if ( $last_error && in_array( $last_error['type'], $this->fatal_errors, true ) ) {
            $this->is_fatal = true;
            $this->handleErrors( $last_error['type'], $last_error['message'], $last_error['file'],
                $last_error['line'] );
        }
    }
    /**
     * Build pretty error details.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @return  string
     */
    protected function buildErrorDetails()
    {
        // Get reverse sorted backtrace
        $backtrace = array_reverse( debug_backtrace() );
        array_pop( $backtrace ); // Remove this method
        array_pop( $backtrace ); // Remove error handler
        if ( ! empty( $backtrace ) ) {
            $output .= "Stack trace:"
                . PHP_EOL;
            for ( $i = 0, $len = count( $backtrace ); $i < $len; $i ++ ) {
                $output .= "\t#"
                    . $i
                    . "\t"
                    . "triggered at ";
                if ( isset( $backtrace[$i]['class'] ) ) {
                    $method = new \ReflectionMethod( $backtrace[$i]['class'],
                        $backtrace[$i]['function'] );
                    $output .= $backtrace[$i]['class'];
                    $output .= ($method->isStatic()) ? "::" : "->";
                }
                if ( isset( $backtrace[$i]['function'] ) ) {
                    $output .= $backtrace[$i]['function']
                        . "(";
                }
                if ( ! empty( $backtrace[$i]['args'] ) ) {
                    for ( $x = 0; $x < count( $backtrace[$i]['args'] ); $x ++ ) {
                        if ( is_array( $backtrace[$i]['args'][$x] ) ) {
                            $value = 'Array';
                        } else if ( is_null( $backtrace[$i]['args'][$x] ) ) {
                            $value = 'null';
                        } else if ( is_string( $backtrace[$i]['args'][$x] ) ) {
                            $value = "'" . $backtrace[$i]['args'][$x] . "'";
                        } else {
                            $value = $backtrace[$i]['args'][$x];
                        }
                        $output .= $value
                            . ", ";
                    }
                    $output = substr( $output, 0, -2 );
                }
                $output .= ")";
                if ( isset( $backtrace[$i]['file'] ) ) {
                    $output .= " in "
                        . $backtrace[$i]['file'];
                }
                if ( isset( $backtrace[$i]['line'] ) ) {
                    $output .= " on line "
                        . $backtrace[$i]['line'];
                }
                $output .= PHP_EOL;
            }
        }
        $output .= PHP_EOL;

        return $output;
    }
}