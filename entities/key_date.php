<?php
class KeyDate {
    // Connection instance
    private $connection;

    //errors
    public $stmtError;

    // table name
    private $table_name = "KeyDates";

    // table columns
    public $id;
    public $keydates;
    public $doubled;
    public $PersonID;

    public function __construct($connection){
        $this->connection = $connection;
    }

    //Create
    public function create(){
        // query to insert user
        $query = "INSERT INTO $this->table_name(keydates, doubled, PersonID)".
            "VALUES(:keydate, :dlb, :pID)";

        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->keydates = htmlspecialchars(strip_tags($this->keydates));
        $this->doubled = htmlspecialchars(strip_tags($this->doubled));
        $this->PersonID = htmlspecialchars(strip_tags($this->PersonID));

        // bind values
        $stmt->bindParam(":keydate", $this->keydates);
        $stmt->bindParam(":dlb", $this->doubled);
        $stmt->bindParam(":pID", $this->PersonID);
 

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

    //Get one user date
    public function get_user_date(){
        $query = "SELECT * FROM $this->table_name WHERE PersonID=?";

        // sanitize
        $this->PersonID = htmlspecialchars(strip_tags($this->PersonID));

        $stmt = $this->connection->prepare($query);

        // bind values
        $stmt->bindParam(1, $this->PersonID);

        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->id = $row['id'];
        $this->keydates = $row['keydates'];
        $this->doubled = $row['doubled'];
        
        return $stmt;
    }

    //Update
    public function update(){
        // query to update user
        $query = "UPDATE $this->table_name SET keydates=:kdate, doubled=:dbl, PersonID=:pID WHERE id=:id";
        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->keydates = htmlspecialchars(strip_tags($this->keydates));
        $this->doubled = htmlspecialchars(strip_tags($this->doubled));
        $this->PersonID = htmlspecialchars(strip_tags($this->PersonID));        


        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":kdate", $this->keydates);
        $stmt->bindParam(":dbl", $this->doubled);
        $stmt->bindParam(":pID", $this->PersonID);
 

        // execute query
        if($stmt->execute()) {
            return true;
        }

        $this->stmtError = $stmt->error;

        return false;
    }
    //Delete
    public function delete(){
        // query to delete date
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

        $this->stmtError = $stmt->rowCount(). " dates were affected";

        return false;
    }
}
?>