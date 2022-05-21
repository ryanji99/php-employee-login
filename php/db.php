<?php
require_once 'config.php';
class db
{
    private static $instance = null;
    protected $connection;
    protected $query;
    protected $show_errors = TRUE;
    protected $query_closed = TRUE;
    public $query_count = 0;

    public function __construct()
    {
        list(
            'address' => $dsn,
            'mysqlusername' => $user,
            'password' => $pass,
            'databaseName' => $database
        ) = config::$config['databaseAuth'];

        $this->connection = new \mysqli("$dsn", "$user", "$pass", "$database");
        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQL";
        }
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }

    public function prepare($query)
    {
        return mysqli_prepare($this->connection, $query);
    }
}
