<?php

namespace App\Database;

class DB_MYSQL {

  protected $database;
  protected $connection = false;

  public function __construct($host, $password, $username, $db)
  {
    $this->connect($host, $username, $password, $db);
  }
    
  private function connect($host, $username, $password, $db)
  {
    if(!$this->connection)
    {
      $this->database = new \mysqli($host, $username, $password, $db);
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
    ** INSERT FUNCTION **
    * INSERT ONE *
  */
  public function insertOneInto($table, $columns, $values)
  {
    if(!$this->connection)
    {
      $this->connect();
    }

    $this->database->query("INSERT INTO $table ($columns) VALUES ($values)");
    $last_id = $this->database->insert_id;

    return $last_id;
  }

  /**
    * INSERT MULTIPLE INTO *
  */
  public function insertMultipleInto($table, $data)
  {
    if(!$this->connection)
    {
      $this->connect();
    }

    $sql_statement = "";
    foreach ($data as $columns => $values) {
      $sql_statement .= "INSERRT INTO $table ($columns) VALUES ($values)";
    }

    $this->database->multi_query($sql_statement);
  }

  /**
  * UPDATE ONE *
  */
  public function updateOne($table, $id, $data)
  {
    if(!$this->connection)
    {
      $this->connect();
    }

    $sql_update_statement = "";
    foreach ($data as $column => $value) {
      $sql_update_statement .= "$column = $value,";
    }

    $this->database->query("UPDATE $table SET $sql_update_statement WHERE id=$id");
  }

  /**
    * DELETE ONE *
  */
  public function deleteOne($table, $id)
  {
    if(!$this->connection)
    {
      $this->connect();
    }

    $this->database->query("DELETE FROM $table WHERE id=$id");
  }


  /**
    * DELETE MULTIPLE *
  */
  public function deleteMultiple($table, $data)
  {
    if(!$this->connection)
    {
      $this->connect();
    }

    $sql_statment = "";
    for ($i=0; $i <= count($data); $i++) { 
      $sql_statement .= "DELETE FROM $table WHERE id=" . $data[$i];
    }
    $this->database->multi_query($sql_statement);
  }
}
