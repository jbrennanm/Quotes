<?php
// This class has a constructor to connect to a database. The given
// code assumes you have created a database named 'quotes' inside MariaDB.
//
// Call function startByScratch() to drop quotes if it exists and then create
// a new database named quotes and add the two tables (design done for you).
// The function startByScratch() is only used for testing code at the bottom.
// 
// Authors: Rick Mercer and Brennan Mitchell
//
class DatabaseAdaptor {
  private $DB; // The instance variable used in every method below
  // Connect to an existing data based named 'quotes'
  public function __construct() {
    $dataBase ='mysql:dbname=quotes;charset=utf8;host=127.0.0.1';
    $user ='root';
    $password =''; // Empty string with XAMPP install
    try {
        $this->DB = new PDO ( $dataBase, $user, $password );
        $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) {
        echo ('Error establishing Connection');
        exit ();
    }
  }
    
// This function exists only for testing purposes. Do not call it any other time.
public function startFromScratch() {
  $stmt = $this->DB->prepare("DROP DATABASE IF EXISTS quotes;");
  $stmt->execute();
       
  // This will fail unless you created database quotes inside MariaDB.
  $stmt = $this->DB->prepare("create database quotes;");
  $stmt->execute();

  $stmt = $this->DB->prepare("use quotes;");
  $stmt->execute();
        
  $update = " CREATE TABLE quotations ( " .
            " id int(20) NOT NULL AUTO_INCREMENT, added datetime, quote varchar(2000), " .
            " author varchar(100), rating int(11), flagged tinyint(1), PRIMARY KEY (id));";       
  $stmt = $this->DB->prepare($update);
  $stmt->execute();
                
  $update = "CREATE TABLE users ( ". 
            "id int(6) unsigned AUTO_INCREMENT, username varchar(64),
            password varchar(255), PRIMARY KEY (id) );";    
  $stmt = $this->DB->prepare($update);
  $stmt->execute(); 
}
    

// ^^^^^^^ Keep all code above for testing  ^^^^^^^^^


/////////////////////////////////////////////////////////////
// Complete these five straightfoward functions and run as a CLI application


    public function getAllQuotations() {
        $join = "SELECT * FROM quotations ORDER BY rating DESC;";
        $stmt = $this->DB->prepare($join);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllUsers(){
        $join = "SELECT * FROM users;";
        $stmt = $this->DB->prepare($join);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addQuote($quote, $author) {
        $stmt = $this->DB->prepare("INSERT INTO quotations (quote, author, rating, flagged) " .
            " VALUES (:bind_quote, :bind_author, '0', '0');");
        $stmt->bindParam(':bind_quote', $quote );
        $stmt->bindParam(':bind_author', $author );
        $stmt->execute(); 
    }
    
    public function addUser($accountname, $psw){
        $pswHash = password_hash($psw, PASSWORD_DEFAULT); // hashes password before Database entry
        $stmt = $this->DB->prepare("INSERT INTO users (username, password) VALUES (:bind_user, :bind_psw);");
        $stmt->bindParam(':bind_user', $accountname );
        $stmt->bindParam(':bind_psw', $pswHash );
        $stmt->execute();
    }   


    public function verifyCredentials($accountName, $psw){
        $join = "SELECT * FROM users;";
        $stmt = $this->DB->prepare($join);
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        for ($i = 0; $i < sizeof($arr); $i ++) {
            if ($arr[$i]['username'] === $accountName) {
                if (password_verify($psw, $arr[$i]['password'])) { // verifies if hashed password matches String psw
                    return true;
                }
            }
        }
        return false;
    }
    
    public function usernameExists($accountName){
        $join = "SELECT * FROM users;";
        $stmt = $this->DB->prepare($join);
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        for ($i = 0; $i < sizeof($arr); $i ++) {
            if ($arr[$i]['username'] === $accountName) {
                return true;
            }
        }
        return false;
    }
    
    public function raiseRating($ID) {
        // raise the rating of the quote by 1
        $stmt = $this->DB->prepare("UPDATE quotations SET rating = rating+1 WHERE id =:bind_id;");
        $stmt->bindParam(':bind_id', $ID);
        $stmt->execute();
    }
    
    public function lowerRating($ID) {
        // lower the rating of the quote by 1
        $stmt = $this->DB->prepare("UPDATE quotations SET rating = rating-1 WHERE id =:bind_id;");
        $stmt->bindParam(':bind_id', $ID);
        $stmt->execute();
    }
    
    public function deleteQuote($ID) {
        // deletes a quote from the database using the quotes ID
        $stmt = $this->DB->prepare("DELETE FROM quotations WHERE id =:bind_id;");
        $stmt->bindParam(':bind_id', $ID);
        $stmt->execute();
    }

}  // End class DatabaseAdaptor


?>
