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
 * @version     $Id: Session.php,v 0.0.1 07.01.2016 10:36:15 mitopp Exp $;
 */
class Session extends \SessionHandler
{
    /**
     * Encryption/Decryption key.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @var     string
     */
    protected $key;

    /**
     * CONSTRUCTOR
     *
     * Configure the server environment, create a key for encryption/decryption, register the
     * custom session handler and start the session.
     *
     * @since   0.0.1
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        // Configure server environment
        ini_set( 'session.use_trans_sid', false );  // Disable transparent SID
        ini_set( 'session.save_path', SESSION_SAVE_PATH );
        ini_set( 'session.save_handler', 'files' );
        ini_set( 'session.session.gc_probability', SESSION_GC_PROB );
        ini_set( 'session.gc_divisor', SESSION_GC_DIV );
        ini_set( 'session.gc_maxlifetime', SESSION_MAX_LIFETIME );

        // Create secret key for encryption
        $this->key = pack( 'H*', md5( ABSPATH ) );

        // Register own session handler
        $this->register();

        // Start session
        $this->start();
    }
    /**
     * Initialize session.
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   string  $save_path  The path where to store/retrieve the session
     * @param   string  $session_id The session name
     * @return  bool    True on success, false on failure
     */
    public function open( $save_path, $session_id )
    {
        return parent::open( $save_path, $session_id );
    }
    /**
     * Close the session.
     *
     * @since   0.0.1
     *
     * @access  public
     * @return  bool    True on success, false on failure
     */
    public function close()
    {
        return parent::close();
    }
    /**
     * Read session data.
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   string  $session_id The session id to read data for
     * @return  mixed   Encoded string or empty string on failure
     */
    public function read( $session_id )
    {
        $data = parent::read( $session_id );

        return mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $this->key, $data, MCRYPT_MODE_ECB );
    }
    /**
     * Write session data.
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   string  $session_id     The session id
     * @param   string  $session_data   The encoded session data
     * @return  bool    True on success, false on failure
     */
    public function write( $session_id, $session_data )
    {
        $data = mcrypt_encrypt( MCRYPT_RIJNDAEL_128, $this->key, $session_data, MCRYPT_MODE_ECB );

        return parent::write( $session_id, $data );
    }
    /**
     * Destroy a session.
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   string  $session_id The session ID being destroyed
     * @return  bool    True on success, false on failure
     */
    public function destroy( $session_id )
    {
        return parent::destroy( $session_id );
    }
    /**
     * Cleanup old sessions
     *
     * @since   0.0.1
     *
     * @access  public
     * @param   int     $maxlifetime    Lifetime of session
     * @return  bool    True on success, false on failure
     */
    public function garbage( $maxlifetime )
    {
        return parent::gc( $maxlifetime );
    }
    /**
     * Start the session handling
     *
     * @since   0.0.1
     *
     * @access  protected
     * @return  void
     */
    protected function start()
    {
        // Start or use a session
        session_start();

        // Replace the current session ID with a new one and delete the old.
        // Prevents session hijacking
        session_regenerate_id( true );
    }
    /**
     * Register the custom session handler.
     *
     * @since   0.0.1
     *
     * @access  protected
     * @return  bool        Returns true on success or false on failure.
     */
    protected function register()
    {
        // Cancel the session's auto start
        session_write_close();

        // Register own session handler
        return session_set_save_handler(
            array( $this, 'open' ), array( $this, 'close' ), array( $this, 'read' ),
            array( $this, 'write' ), array( $this, 'destroy' ), array( $this, 'garbage' )
        );
    }
}