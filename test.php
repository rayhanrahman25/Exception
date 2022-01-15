<?php
class ServerloadException extends Exception{}
class NetworkException extends Exception{}
class DiskfullException extends Exception{}

interface DBconnection{
  function connect();
  function getName();
  function report($data);
}

class MySQl implements DBconnection{
  function connect(){
    throw new ServerloadException;
  }
  function getName(){
    echo "MySQL";
  }
  function report($data)
  {
    
  }
}
class PostgreSQl implements DBconnection{
  function connect(){
  throw new NetworkException;
  }
  function getName(){
    echo "PostgreSQL";
  }
  function report($data)
  {
    
  }
}
class MongoDB implements DBconnection{
  function connect(){
    throw new DiskfullException;
  }
  function getName(){
    echo "MongoDB";
  }
  function report($data)
  {
    
  }
}
class MSSQl implements DBconnection{
  function connect(){
    throw new DiskfullException;
  }
  function getName(){
    return true;
  }
  function report($data)
  {
    
  }
}

class ConnectionPool{
    protected $storage;
    protected $connection;
    function __construct(){
        $this->storage = array();
    }
    function addStorage(DBconnection $storage){
      array_push($this->storage, $storage);
    }
    function getConnection(){
      foreach($this->storage as $storage){
        try{
        $this->connection =  $storage->connect();
        }catch(DiskfullException $e){
          echo $storage->getName()." Disk is full remove unused accessories\n";
        }catch(NetworkException $e){
          echo $storage->getName()."Your Network Facing Issues\n";
        }catch(ServerloadException $e){
          echo $storage->getName()."Server Is Facing Too Much Loading\n";
        }
      
      }
      if($this->connection){
        return $this->connection;
      }
      return false;
    }
}
$ms = new MSSQl;
$mysql = new MySQL;
$pg = new PostgreSQl;
$mdb = new MongoDB;

$cp = new ConnectionPool;

$cp->addStorage($mysql);
$cp->addStorage($pg);
$cp->addStorage($mdb);
$cp->addStorage($ms);

$connection = $cp->getConnection();
print_r($connection);

