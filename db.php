<?php 
class db {
   private $host = "localhost";
   private $username = "root";
   private $database = "admin";
   private $password = "";
   protected $db;

   public function __construct()
   {
      try 
      {
          $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database,$this->username, $this->password);
      } 
      catch(PDOException $e)
      {
          echo "Connection Problem: ". $e->getMessage();
      }
   }
}
 ?>