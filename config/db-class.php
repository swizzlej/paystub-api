<?php
class DBClass {

    private $host = "pdb23.awardspace.net";
    private $username = "2617443_paystub";
    private $password = "Supercomputer_2008";
    private $database = "2617443_paystub";

    public $connection;

    // get the database connection
    public function getConnection(){

        $this->connection = null;

        try{
            $this->connection = new PDO(
                "mysql:host=" . $this->host . 
                ";dbname=" . $this->database, $this->username, $this->password
            );
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>