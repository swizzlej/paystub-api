<?php
class FinanceDetail {
    // Connection instance
    private $connection;

    //errors
    public $stmtError;

    // table name
    private $table_name = "FinanceDetails";

    // table columns
    public $id;
    public $rate;
    public $firstPayDay;
    public $PersonID;

    public function __construct($connection){
        $this->connection = $connection;
    }

    //Create
    public function create(){
        // query to insert financial detail
        $query = "INSERT INTO $this->table_name(rate, firstPayDay, PersonID)".
            "VALUES(:rate, :fPayDay, :pID)";

        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->rate = htmlspecialchars(strip_tags($this->rate));
        $this->firstPayDay = htmlspecialchars(strip_tags($this->firstPayDay));
        $this->PersonID = htmlspecialchars(strip_tags($this->PersonID));

        // bind values
        $stmt->bindParam(":rate", $this->rate);
        $stmt->bindParam(":fPayDay", $this->firstPayDay);
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
        // query to update finance detail
        $query = "UPDATE $this->table_name SET rate=:rate, firstPayDay=:fPayDay, PersonID=:pID WHERE id=:id";
        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->rate = htmlspecialchars(strip_tags($this->rate));
        $this->firstPayDay = htmlspecialchars(strip_tags($this->firstPayDay));
        $this->PersonID = htmlspecialchars(strip_tags($this->PersonID));        


        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":rate", $this->rate);
        $stmt->bindParam(":fPayDay", $this->firstPayDay);
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

        $this->stmtError = $stmt->rowCount(). " details were affected";

        return false;
    }
}
?>