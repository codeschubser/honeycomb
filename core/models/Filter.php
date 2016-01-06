<?php

namespace de\codeschubser\honeycomb\core\models;

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
 * @abstract
 * @category    Honeycomb | Groupware
 * @package     Core
 * @author      Michael Topp <blog@codeschubser.de>
 * @copyright   Copyright (c), 2016 Codeschubser.de
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version     $Id: Filter.php,v 0.0.1 06.01.2016 13:36:15 mitopp Exp $;
 */
abstract class Filter
{
    /**
     * Gets a specific external SERVER variable by name and filters it.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function server( $name, $filter = FILTER_SANITIZE_STRING, $options = null )
    {
        return filter_input( INPUT_SERVER, $name, $filter, $options );
    }
    /**
     * Gets a specific external SERVER variable by name and validate it as boolean.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function serverBool( $name, $options = null )
    {
        return self::server( $name, FILTER_VALIDATE_BOOLEAN, $options );
    }
    /**
     * Returns filtered SERVER variables.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Array of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function servers( $filter = FILTER_SANITIZE_STRING, $options = null )
    {
        return filter_input_array( INPUT_SERVER, $filter, $options );
    }
    /**
     * Gets a specific external POST variable by name and filters it.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function post( $name, $filter = FILTER_SANITIZE_STRING, $options = null )
    {
        return filter_input( INPUT_POST, $name, $filter, $options );
    }
    /**
     * Gets a specific external POST variable by name and validate as integer.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function postInt( $name, $options = null )
    {
        return self::post( $name, FILTER_VALIDATE_INT, $options );
    }
    /**
     * Gets a specific external POST variable by name and validate as float.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function postFloat( $name, $options = null )
    {
        return self::post( $name, FILTER_VALIDATE_FLOAT, $options );
    }
    /**
     * Gets a specific external POST variable by name and validate as email.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function postEmail( $name, $options = null )
    {
        return self::post( $name, FILTER_VALIDATE_EMAIL, $options );
    }
    /**
     * Gets a specific external POST variable by name and validate as ip address.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function postIP( $name, $options = null )
    {
        return self::post( $name, FILTER_VALIDATE_IP, $options );
    }
    /**
     * Returns filtered POST variables.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Array of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function posts( $filter = FILTER_SANITIZE_STRING, $options = null )
    {
        return filter_input_array( INPUT_POST, $filter, $options );
    }
    /**
     * Gets a specific external GET variable by name and filters it.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function get( $name, $filter = FILTER_SANITIZE_STRING, $options = null )
    {
        return filter_input( INPUT_GET, $name, $filter, $options );
    }
    /**
     * Gets a specific external GET variable by name and validate as integer.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function getInt( $name, $options = null )
    {
        return self::get( $name, FILTER_VALIDATE_INT, $options );
    }
    /**
     * Gets a specific external GET variable by name and validate as float.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function getFloat( $name, $options = null )
    {
        return self::get( $name, FILTER_VALIDATE_FLOAT, $options );
    }
    /**
     * Gets a specific external GET variable by name and validate as email.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function getEmail( $name, $options = null )
    {
        return self::get( $name, FILTER_VALIDATE_EMAIL, $options );
    }
    /**
     * Gets a specific external GET variable by name and validate as ip address.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function getIP( $name, $options = null )
    {
        return self::get( $name, FILTER_VALIDATE_IP, $options );
    }
    /**
     * Returns filtered GET variables.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Array of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function gets( $filter = FILTER_SANITIZE_STRING, $options = null )
    {
        return filter_input_array( INPUT_GET, $filter, $options );
    }
    /**
     * Gets a specific variable by name and filters it.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function variable( $name, $filter = FILTER_SANITIZE_STRING, $options = null )
    {
        return filter_var( INPUT_GET, $name, $filter, $options );
    }
    /**
     * Gets a specific variable by name and validate it as integer.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function variableInt( $name, $options = null )
    {
        return self::variable( $name, FILTER_VALIDATE_INT, $options );
    }
    /**
     * Gets a specific variable by name and validate it as float.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function variableFloat( $name, $options = null )
    {
        return self::variable( $name, FILTER_VALIDATE_FLOAT, $options );
    }
    /**
     * Gets a specific variable by name and validate it as email.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $name       Name of the variable.
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Value of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function variableEmail( $name, $options = null )
    {
        return self::variable( $name, FILTER_VALIDATE_EMAIL, $options );
    }
    /**
     * Returns filtered variables.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   array   $variables  An array to filter.
     * @param   int     $filter     Optional. The ID of the filter to apply. Default:513
     * @param   mixed   $options    Optional. Associative array of options or bitwise disjunction of flags. Default:null
     * @return  mixed               Array of the requested variable on success, FALSE if the filter
     *                              fails or NULL if the $name variable is not set.
     */
    public static function variables( array $variables, $filter = FILTER_SANITIZE_STRING,
        $options = null )
    {
        return filter_var_array( $variables, $filter, $options );
    }
    /**
     * Walks the array while sanitizing the contents.
     *
     * @since   0.0.1
     *
     * @see     \addslashes()
     *
     * @access  public
     * @param   array   $array  Array to walk while sanitizing contents.
     * @return  array   Sanitized $array.
     */
    public static function addMagicQuotes( array $array )
    {
        foreach ( (array)$array as $key => $value ) {
            if ( is_array( $value ) ) {
                $array[$key] = self::addMagicQuotes( $value );
            } else {
                $array[$key] = addslashes( $value );
            }
        }

        return $array;
    }
}