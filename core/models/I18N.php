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
 * @version     $Id: I18N.php,v 0.0.1 06.01.2016 10:14:57 mitopp Exp $;
 */
abstract class I18N
{
    /**
     * Set the environment for internationalization.
     *
     * @since   0.0.1
     *
     * @see     getLocale()
     *
     * @access  public
     * @static
     * @param   string  $locale Optional. Locale to set. If not set, the locale was detected from
     *                          session and browser setting. Default: null
     * @return  bool
     */
    public static function setLocale( $locale = null )
    {
        if ( null === $locale || ! self::isValid( $locale ) ) {
            $locale = self::getLocale();
        }

        $locale_charset = sprintf( '%1$s.%2$s', $locale, 'utf-8' );

        putenv( 'LC_ALL=' . $locale_charset );
        putenv( 'LANG=' . $locale_charset );
        putenv( 'LANGUAGE=' . $locale_charset );

        $set = setlocale( LC_ALL, $locale_charset );

        // Store selected locale in session
        if ( $set ) {
            $_SESSION['locale'] = $locale;
        }

        return $set;
    }
    /**
     * Returns the locale from session or from browser settings.
     * If not locale found, the default locale was set.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @return  string
     */
    public static function getLocale()
    {
        $locale = null;

        // From session
        if ( isset( $_SESSION['locale'] ) ) {
            $locale = $_SESSION['locale'];
        }

        // From browser
        if ( ! $locale ) {
            $locale = self::getLocaleFromBrowser();
        }
        // Default locale
        if ( ! $locale ) {
            $locale = LANGUAGE;
        }

        return $locale;
    }
    /**
     * Returns the prevered locale from HTTP_ACCEPT_LANGUAGE.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @static
     * @return  string|bool Locale from SERVER, FALSE on failure.
     */
    protected static function getLocaleFromBrowser()
    {
        $accepted_languages = Filter::server( 'HTTP_ACCEPT_LANGUAGE' );

        if ( $accepted_languages ) {
            if ( function_exists( 'locale_accept_from_http' ) ) {
                return locale_accept_from_http( $accepted_languages );
            } else {
                $parsed_languages = array();
                if ( preg_match_all( '#([a-z]{1,8})(-[a-z]{1,8})*\s*(;\s*q\s*=\s*((1(\.0{0,3}))|(0(\.[0-9]{0,3}))))?#i',
                        $accepted_languages, $parsed_languages ) ) {
                    $languages = (isset( $parsed_languages[1] ) ? $parsed_languages[1] : array());
                    $countries = (isset( $parsed_languages[2] ) ? $parsed_languages[2] : array());
                    $qualities = (isset( $parsed_languages[4] ) ? $parsed_languages[4] : array());

                    $temp = array();

                    if ( $languages ) {
                        for ( $i = 0, $len = count( $languages ); $i < $len; $i ++ ) {
                            if ( isset( $countries[$i] ) && ! empty( $countries[$i] ) ) {
                                $language = strtolower( $languages[$i] );
                                $country = strtoupper( $countries[$i] );
                                $quality = isset( $qualities[$i] ) ? (empty( $qualities[$i] ) ? 1.0 : floatval( $qualities[$i] )) : 0.0;

                                $locale = str_replace( '-', '_', $language . $country );

                                $temp[$locale] = (isset( $temp[$locale] )) ? max( $temp[$locale],
                                        $quality ) : $quality;
                            }
                        }
                    }

                    arsort( $temp, SORT_NUMERIC );

                    $keys = array_keys( $temp );

                    return array_shift( $keys );
                }
            }
        }

        return false;
    }
    /**
     * Check if a locale is valid formatted.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @static
     * @param   string  $locale Locale to check.
     * @return  bool    True if is a valid locale format, false if not.
     */
    protected static function isValid( $locale )
    {
        return (bool)preg_match( '#^[a-z]{2}_[A-Z]{2}(\S+)?$#', $locale );
    }
}