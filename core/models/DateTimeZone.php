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
 * @version     $Id: DateTimeZone.php,v 0.0.1 07.01.2016 11:15:03 mitopp Exp $;
 */
class DateTimeZone extends \DateTimeZone
{
    /**
     * CONSTRUCTOR
     * Build a new DateTimeZone object.
     * Store user timezone identifier in session.
     *
     * @since   0.0.1
     *
     * @see     getTimeZone()
     *
     * @access  public
     * @param   string|null $timezone   Optional. Timezone identifier to use. Default: null
     * @return  void
     */
    public function __construct( $timezone = null )
    {
        if ( null === $timezone ) {
            $timezone = self::getTimeZone();
        }

        // Store timezone in session
        $_SESSION['timezone'] = $timezone;

        parent::__construct( $timezone );
    }
    /**
     * Returns the timezone identifier from session or from defaults.
     *
     * @since   0.0.1
     *
     * @access  public
     * @static
     * @return  string  Timezone identifier to use.
     */
    public static function getTimeZone()
    {
        $timezone = null;

        if ( isset( $_SESSION['timezone'] ) ) {
            $timezone = $_SESSION['timezone'];
        }

        if ( ! $timezone ) {
            $timezone = TIMEZONE;
        }

        return $timezone;
    }
}