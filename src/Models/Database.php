<?php
class Database
{
    /**
     * @var Database
     */
    protected static $dbInstance = null;

    /**
     * @var PDO
     */
    protected $dbHandle;

    /**
     * @return Database
     */
    public static function getInstance()
    {
        $username = 'REDACTED';
        $password = 'REDACTED';
        $host = 'REDACTED';
        $dbName = 'REDACTED';

        if (self::$dbInstance === null) { //checks if the PDO exists
            // creates new instance if not, sending in connection info
            self::$dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$dbInstance;
    }

    /**
     * @param $username
     * @param $password
     * @param $host
     * @param $database
     */
    private function __construct($username, $password, $host, $database)
    {
        try {
            $this->dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password); // creates the database handle with connection info

        } catch (PDOException $e) { // catch any failure to connect to the database
            echo $e->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getdbConnection()
    {
        return $this->dbHandle; // returns the PDO handle to be used
    }

    public function __destruct()
    {
        $this->dbHandle = null; // destroys the PDO handle when no longer needed
    }
}
