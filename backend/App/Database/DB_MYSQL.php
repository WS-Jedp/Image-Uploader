<?php

namespace App\Database;

use \App\Helpers\ErrorReport;

class DB_MYSQL {

  protected $database;
  protected $connection = false;

  private $host = 'localhost:3306';
  private $password = 'Jedp05022001082';
  private $username = 'root';
  private $db = 'image_uploader';

  public function __construct()
  {
    $this->connect($this->host, $this->username, $this->password, $this->db);
  }
    
  private function connect($host, $username, $password, $db)
  {
    if(!$this->connection)
    {
      $this->database = new \mysqli($host, $username, $password, $db);
      $this->connection = true;
    }

    if($this->database->connect_error)
    {
      $this->connection = false;
      die("Connection failed -> " . $this->database->connect_error);
    }

    return "Connection success";
  }

  public function close_connection()
  {
    $this->database->close();
  }

  
  /**
   ** SELECT FUNCTIONS TO GET INFORMATINO 
   * 
   * SELECT MULTIPlE
   */
  public function selectMultiple($table, $columns, $condition = null)
  {
    if(!$this->connection)
    {
      $this->connect($this->host, $this->username, $this->password, $this->db);
    }

    $columns_statement = "";
    for ($i=0; $i <= count($columns); $i++) { 
      $columns_statement .= "$columns[$i]";
      if(!$i === count($columns))
      {
        $columns_statement .= ",";
      }
    }

    $sql_statement = "SELECT $columns_statement FROM $table";

    if(isset($condition))
    {
      $sql_statement .= " WHERE $condition";
    }

    $result = $this->database->query($sql_statement); 
    $json = [];

    if($result->num_rows > 0) 
    {
      while($row = $result->fetch_assoc())
      {
        array_push($json, $row);
      }
      return $json;
    }
  }

  /**
   * SELECT ONE
    */
  public function selectOne($table, $columns, $id)
  {
    $error_report = new ErrorReport();

    if(!$this->connection)
    {
      $this->connect($this->host, $this->username, $this->password, $this->db);
    }

    $columns_statement = "";
    for ($i=0; $i <= count($columns); $i++) { 
      $columns_statement .= "$columns[$i]";
      if(!$i === count($columns))
      {
        $columns_statement .= ",";
      }
    }

    $result = $this->database->query("SELECT $columns_statement FROM $table WHERE id=$id");

    if($this->database->error) {
      return $error_report->report_db_error("The image $id doesn't exists");
    }

    $data = [];
    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        array_push($data, $row);
      }
      return $data;
    }

  }

  /**
    ** INSERT FUNCTION **
    * INSERT ONE *
  */
  public function insertOneInto($table, $columns, $values)
  {
    $error_report = new ErrorReport();
    if(!$this->connection)
    {
      $this->connect($this->host, $this->username, $this->password, $this->db);
    }

    
    if($this->database->query("INSERT INTO $table ($columns) VALUES ('$values')") === TRUE)
    {

      $last_id = $this->database->insert_id;
      return $last_id;
    } else if($this->database->error){
      return $error_report->report_db_error($this->database->error);
    }

  }

  /**
    * INSERT MULTIPLE INTO *
  */
  public function insertMultipleInto($table, $data)
  {
    if(!$this->connection)
    {
      $this->connect($this->host, $this->username, $this->password, $this->db);
    }

    $sql_statement = "";
    foreach ($data as $columns => $values) {
      $sql_statement .= "INSERT INTO $table ($columns) VALUES ($values)";
    }

    $this->database->multi_query($sql_statement);
  }

  /**
  * UPDATE ONE *
  */
  public function updateOne($table, $id, $data)
  {

    $error_report = new ErrorReport();

    if(!$this->connection)
    {
      $this->connect($this->host, $this->username, $this->password, $this->db);

    }

    $sql_update_statement = "";
    $index = 0;
    foreach ($data as $column => $value) {
      $sql_update_statement .= "$column = '$value'";
      if(!$index === count($data))
      {
        $sql_update_statement .= ',';
      }
      $index++;
    }

    if($this->database->query("UPDATE $table SET $sql_update_statement WHERE id=$id") === TRUE)
    {
      return "Created";
    } elseif($this->database->error){
      return $error_report->report_db_error($this->database->error);
    }
  }

  /**
    * DELETE ONE *
  */
  public function deleteOne($table, $id)
  {
    if(!$this->connection)
    {
      $this->connect($this->host, $this->username, $this->password, $this->db);
    }

    return $this->database->query("DELETE FROM $table WHERE id=$id");
  }


  /**
    * DELETE MULTIPLE *
  */
  public function deleteMultiple($table, $data)
  {
    if(!$this->connection)
    {
      $this->connect($this->host, $this->username, $this->password, $this->db);
    }

    $sql_statement = "";
    for ($i=0; $i <= count($data); $i++) { 
      $sql_statement .= "DELETE FROM $table WHERE id=" . $data[$i];
    }
    $this->database->multi_query($sql_statement);
  }
}
