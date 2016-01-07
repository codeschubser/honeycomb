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
 * @category    Honeycomb | Groupware
 * @package     Core
 * @author      Michael Topp <blog@codeschubser.de>
 * @copyright   Copyright (c), 2016 Codeschubser.de
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version     $Id: DateTime.php,v 0.0.1 07.01.2016 11:10:09 mitopp Exp $;
 */
class DateTime extends \DateTime
{
    /**
     * CONSTRUCTOR
     * Build a new DateTime object
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   string|int  $time       Optional. A date/time string. Default: now
     * @param   string|null $timezone   Optional. Timezone identifier or DateTimeZone object. Default: null
     * @return  void
     */
    public function __construct( $time = 'now', $timezone = null )
    {
        if ( null === $timezone || ! $timezone instanceof DateTimeZone ) {
            $timezone = new DateTimeZone();
        }

        parent::__construct( $time, $timezone );
    }
    /**
     * Returns a short formatted date from timezone.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   mixed   $date   Optional. Timestamp or formatted date time. Default: null
     * @return  string  Formatted date.
     */
    public static function getShortDate( $date = null )
    {
        $timestamp = self::getTimestampFromFormat( $date );
        return strftime( '%x', $timestamp );
    }
    /**
     * Returns a short formatted time from timezone.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   mixed   $time   Optional. Timestamp or formatted date time. Default: null
     * @return  string  Formatted time.
     */
    public static function getShortTime( $time = null )
    {
        $timestamp = self::getTimestampFromFormat( $time );
        return strftime( '%X', $timestamp );
    }
    /**
     * Returns a short formatted date time from timezone.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   mixed   $datetime   Optional. Timestamp or formatted date time. Default: null
     * @return  string  Formatted date time.
     */
    public static function getShortDateTime( $datetime = null )
    {
        $timestamp = self::getTimestampFromFormat( $datetime );
        return self::getShortDate( $timestamp ) . ' ' . self::getShortTime( $timestamp );
    }
    /**
     * Returns a long formatted date from timezone.
     * Supported locales: en_US, en_GB, es_ES, de_DE
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   mixed   $date   Optional. Timestamp or formatted date time. Default: null
     * @return  string  Formatted date.
     */
    public static function getLongDate( $date = null )
    {
        $timestamp = self::getTimestampFromFormat( $date );

        $locale = I18N::getLocale();
        $output = null;
        switch ( $locale ) {
            case 'en_US':
            case 'en_GB':
                $output = strftime( '%B, ', $timestamp )
                    . trim( self::getOrdinalNumber( strftime( '%e', $timestamp ) ) )
                    . strftime( ' %Y', $timestamp );
                break;
            case 'es_ES':
                $output = strftime( '%A ', $timestamp )
                    . trim( strftime( '%e', $timestamp ) )
                    . strftime( ' de %B de %Y', $timestamp );
                break;
            default:
                $output = strftime( '%A, ', $timestamp )
                    . trim( strftime( '%e.', $timestamp ) )
                    . strftime( ' %B %Y', $timestamp );
                break;
        }

        return $output;
    }
    /**
     * Returns a short formatted date time from timezone.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   mixed   $datetime   Optional. Timestamp or formatted date time. Default: null
     * @return  string  Formatted date time.
     */
    public static function getLongDateTime( $datetime = null )
    {
        $timestamp = self::getTimestampFromFormat( $datetime );

        return self::getLongDate( $timestamp ) . ', ' . self::getShortTime( $datetime );
    }
    /**
     * Returns a short formatted string from timezone.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @param   string  $format     Format to use.
     * @param   mixed   $datetime   Optional. Timestamp or formatted date time. Default: null
     * @return  string  Formatted date time string.
     */
    public static function getFormattedTimestamp( $format, $datetime = null )
    {
        $timestamp = self::getTimestampFromFormat( $datetime );

        return strftime( $format, $timestamp );
    }
    /**
     * Returns a unix timestamp from a formatted date time string.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @static
     * @param   string  $formatted  Date time string to use.
     * @return  int     Unix timestamp.
     */
    protected static function getTimestampFromFormat( $formatted )
    {
        if ( ! is_numeric( $formatted ) ) {
            $dt = new self( $formatted );
            return $dt->getTimestamp();
        }

        return $formatted;
    }
    /**
     * Returns the ordinal version of a number.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @static
     * @param   numeric $number The number to use.
     * @return  string  The ordinal formatted number.
     */
    protected static function getOrdinalNumber( $number )
    {
        $ends = array( 'th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th' );
        if ( (($number % 100) >= 11) && (($number % 100) <= 13) )
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }
}