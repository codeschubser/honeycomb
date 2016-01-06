<?php

namespace de\codeschubser\honeycomb\core\controllers;

/**
 * PSR-4 Autoloader
 *
 * An example of a general-purpose implementation that includes the optional
 * functionality of allowing multiple base directories for a single namespace
 * prefix.
 *
 * Given a foo-bar package of classes in the file system at the following
 * paths ...
 *
 *     /path/to/packages/foo-bar/
 *         src/
 *             Baz.php             # Foo\Bar\Baz
 *             Qux/
 *                 Quux.php        # Foo\Bar\Qux\Quux
 *         tests/
 *             BazTest.php         # Foo\Bar\BazTest
 *             Qux/
 *                 QuuxTest.php    # Foo\Bar\Qux\QuuxTest
 *
 * ... add the path to the class files for the \Foo\Bar\ namespace prefix
 * as follows:
 *
 *      <?php
 *      // instantiate the loader
 *      $loader = new \Example\Psr4AutoloaderClass;
 *
 *      // register the autoloader
 *      $loader->register();
 *
 *      // register the base directories for the namespace prefix
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\Quux class from /path/to/packages/foo-bar/src/Qux/Quux.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\Quux;
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\QuuxTest class from /path/to/packages/foo-bar/tests/Qux/QuuxTest.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\QuuxTest;
 *
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
 * @since       0.0.1
 * @see         https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 *
 * @category    Honeycomb | Groupware
 * @package     Core
 * @author      Michael Topp <blog@codeschubser.de>
 * @copyright   Copyright (c), 2016 Codeschubser.de
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version     $Id: Autoload.php,v 0.0.1 06.01.2016 09:39:43 mitopp Exp $;
 */
class Autoload
{
    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @var     array
     */
    protected $prefixes = array();

    /**
     * Register loader with SPL autoloader stack.
     *
     * @since   0.0.1
     *
     * @access  public
     * @return  void
     */
    public function register()
    {
        spl_autoload_register( array( $this, 'loadClass' ) );
    }
    /**
     * Adds a base directory for a namespace prefix.
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   string  $prefix     The namespace prefix.
     * @param   string  $base_dir   A base directory for class files in the namespace.
     * @param   bool    $prepend    If true, prepend the base directory to the stack
     *                              instead of appending it; this causes it to be searched first
     *                              rather than last.
     * @return  void
     */
    public function addNamespace( $prefix, $base_dir, $prepend = false )
    {
        // normalize namespace prefix
        $prefix = trim( $prefix, '\\' ) . '\\';

        // normalize the base directory with a trailing separator
        $base_dir = rtrim( $base_dir, DIRECTORY_SEPARATOR ) . '/';

        // initialize the namespace prefix array
        if ( isset( $this->prefixes[$prefix] ) === false ) {
            $this->prefixes[$prefix] = array();
        }

        // retain the base directory for the namespace prefix
        if ( $prepend ) {
            array_unshift( $this->prefixes[$prefix], $base_dir );
        } else {
            array_push( $this->prefixes[$prefix], $base_dir );
        }
    }
    /**
     * Loads the class file for a given class name.
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   string  $class  The fully-qualified class name.
     * @return  mixed   The mapped file name on success, or boolean false on failure.
     */
    public function loadClass( $class )
    {
        // the current namespace prefix
        $prefix = $class;

        // work backwards through the namespace names of the fully-qualified
        // class name to find a mapped file name
        while ( false !== $pos = strrpos( $prefix, '\\' ) ) {

            // retain the trailing namespace separator in the prefix
            $prefix = substr( $class, 0, $pos + 1 );

            // the rest is the relative class name
            $relative_class = substr( $class, $pos + 1 );

            // try to load a mapped file for the prefix and relative class
            $mapped_file = $this->loadMappedFile( $prefix, $relative_class );
            if ( $mapped_file ) {
                return $mapped_file;
            }

            // remove the trailing namespace separator for the next iteration
            // of strrpos()
            $prefix = rtrim( $prefix, '\\' );
        }

        // never found a mapped file
        return false;
    }
}