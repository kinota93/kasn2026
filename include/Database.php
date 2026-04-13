<?php
/**
 * database wrapper, default mysqli
 **/
class Database{
  private $host;
  private $user;
  private $passwd;
  private $dbname;
  private $db;
  function __construct($config) {
    $this->host = $config['host'];
    $this->user = $config['user'];
    $this->passwd = $config['passwd'];
    $this->dbname = $config['dbname'];
    try{
       $this->db = new mysqli($this->host, $this->user, $this->passwd, $this->dbname);
    } catch (mysqli_sql_exception $e){
       error_log($e->__toString());
    }
    if ($this->db){
      $this->db->query('set names utf8');
    }
  }
  public function connect_error(){
    return  $this->db->connect_error;
  }
  public function error(){
    return $this->db->error;
  }
  public function close(){
    $this->db->close();
  }
  public function query($sql, $option=null){
    if ($option!=null) {
      return $this->db->query($sql, $option);
    }
    return $this->db->query($sql);
  }
  public function fetch_array($result){
    return $result->fetch_array(MYSQLI_NUM);
  }
  public function fetch_assoc($result){
    return $result->fetch_assoc();
  }
  public function free($result){
    return $result->close();
  }
  public function num_rows($result){
    return $result->num_rows;
  }
  public function affected_rows(){
    return $this->db->affected_rows;
  }

}
