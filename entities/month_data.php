<?php
class MonthData {
    // Connection instance
    private $connection;

    //errors
    public $stmtError;

    // table name
    private $table_name = "MonthData";

    // table columns
    public $id;
    public $yearMonth;
    public $total;
    public $overtime;
    public $tax;
    public $PersonID;

    public function __construct($connection){
        $this->connection = $connection;
    }

    //Create
    public function create(){
        // query to insert month data
        $query = "INSERT INTO $this->table_name(yearMonth, total, overtime, tax, PersonID)".
            "VALUES(:ymonth, :total, :otime, :tax, :pID)";

        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->yearMonth = htmlspecialchars(strip_tags($this->yearMonth));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->overtime = htmlspecialchars(strip_tags($this->overtime));
        $this->tax = htmlspecialchars(strip_tags($this->tax));
        $this->PersonID = htmlspecialchars(strip_tags($this->PersonID));

        // bind values
        $stmt->bindParam(":ymonth", $this->yearMonth);
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":otime", $this->overtime);
        $stmt->bindParam(":tax", $this->tax);
        $stmt->bindParam(":pID", $this->PersonID);
 
 

        // execute query
        if($stmt->execute()) {
            return true;
        }

        $this->stmtError = $stmt->errorInfo();

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
        // query to update Month data
        $query = "UPDATE $this->table_name SET yearMonth=:ymonth, total=:total, overtime=:otime,".
            "tax=:tax, PersonID=:pID WHERE id=:id";
        
        // prepare query
        $stmt = $this->connection->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->yearMonth = htmlspecialchars(strip_tags($this->yearMonth));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->overtime = htmlspecialchars(strip_tags($this->overtime));
        $this->tax = htmlspecialchars(strip_tags($this->tax));
        $this->PersonID = htmlspecialchars(strip_tags($this->PersonID));        


        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":ymonth", $this->yearMonth);
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":otime", $this->overtime);
        $stmt->bindParam(":tax", $this->tax);
        $stmt->bindParam(":pID", $this->PersonID);
 

        // execute query
        if($stmt->execute()) {
            return true;
        }

        $this->stmtError = $stmt->errorInfo();

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

        $this->stmtError = $stmt->errorInfo();

        return false;
    }
}
?>