<?php
class User {
    // Connection instance
    private $connection;

    //errors
    public $stmtError;

    // table name
    private $table_name = "Persons";

    // table columns
    public $id;
    public $uname;
    public $email;
    public $pword;
    public $hashedPword;
    public $active;

    public function __construct($connection){
        $this->connection = $connection;
    }

    //Create
    public function create(){
        // query to insert user
        $query = "INSERT INTO $this->table_name(username, email, pword, active)".
            "VALUES(:uname, :email, :pword, :active)";

        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->uname = htmlspecialchars(strip_tags($this->uname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->pword = htmlspecialchars(strip_tags($this->pword));
        $this->active = htmlspecialchars(strip_tags($this->active));

        // hash password
        $this->hashedPword = password_hash($this->pword, PASSWORD_DEFAULT);

        // bind values
        $stmt->bindParam(":uname", $this->uname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pword", $this->hashedPword);
        $stmt->bindParam(":active", $this->active);
 

        // execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }
    //Get
    public function get(){
        $query = "SELECT * FROM $this->table_name";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    //Get one
    public function get_one(){
        $query = "SELECT * FROM $this->table_name WHERE id=?";

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt = $this->connection->prepare($query);

        // bind values
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->pword = $row['pword'];
        $this->active = $row['active'];

        return $stmt;
    }

    //Update
    public function update(){
        // query to update user
        $query = "UPDATE $this->table_name SET username=:uname, email=:email, pword=:pword, active=:active WHERE id=:id";
        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->uname = htmlspecialchars(strip_tags($this->uname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->pword = htmlspecialchars(strip_tags($this->pword));
        $this->active = htmlspecialchars(strip_tags($this->active));

        // hash password
        $this->hashedPword = password_hash($this->pword, PASSWORD_DEFAULT);

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":uname", $this->uname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pword", $this->hashedPword);
        $stmt->bindParam(":active", $this->active);
 

        // execute query
        if($stmt->execute()) {
            return true;
        }

        $this->stmtError = $stmt->error;

        return false;
    }
    //Delete
    public function delete(){
        // query to delete user
        $query = "DELETE FROM $this->table_name WHERE id=:id";
        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":id", $this->id);
 

        // execute query
        if($stmt->execute()) {
            if($stmt->rowCount() > 0){
                return true;
            }
            
        }

        $this->stmtError = $stmt->rowCount(). " users were affected";

        return false;
    }
}
?>