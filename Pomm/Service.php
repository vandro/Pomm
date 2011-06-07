<?php

namespace Pomm;

use Pomm\Connection\Database;
use Pomm\Exception\Exception;

/**
 * Service
 * This is the service for the Pomm API.
 * 
 * @package Pomm
 * @version $id$
 * @copyright 2011 Grégoire HUBERT 
 * @author Grégoire HUBERT <hubert.greg@gmail.com>
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 */
class Service
{

    protected $databases = array();

    /**
     * setDatabase
     * save the Database
     *
     * @static
     * @access public
     * @param String name the database name
     * @param Database the database instance
     * @return void
     */

    public function setDatabase($name, Database $database)
    {
        $this->databases[$name] = $database;
    }

    /**
     * getDatabase 
     * Returns the corresponding Database or the first one if no name is provided
     * 
     * @param mixed $name 
     * @access public
     * @return PommDatabase 
     */
    public function getDatabase($name = null)
    {
        if (is_null($name))
        {
            if (count($this->databases) == 0)
            {
                throw new Exception(sprintf('No database registered.'));
            }
            else
            {
                $db = array_values($this->databases);

                return $db[0];
            }
        }
        if (array_key_exists($name, $this->databases))
        {
            return $this->databases[$name];
        }

        throw new Exception(sprintf('No database with this name "%s".', $name));
    }

    /**
     * executeAnonymousSelect 
     * Performs a raw SQL query
     * 
     * @param string $sql 
     * @param string $database 
     * @access public
     * @return PDOStatement
     */
    public function executeAnonymousQuery($sql, $name = null)
    {
        return $this->getDatabase($name)->createConnection()->getPdo()->query($sql, \PDO::FETCH_LAZY);
    }
}