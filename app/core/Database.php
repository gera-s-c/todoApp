<?php
namespace App\Core;

use mysqli;

class Database
{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'todoApp';
    public $con;

    public function __construct()
    {
        $this->con = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->con->connect_error) {
            die("Error de conexión: " . $this->con->connect_error);
        }
    }
}
?>
