<?php
class NetworkException extends Exception{}
class ServerLoadException extends Exception{}
class DiskFullException extends Exception{}
interface NetworkStorage{
    function connect();
    function getName();
}
class MySQL implements NetworkStorage{
    function connect(){
      throw new NetworkException("Network Eroor",101);
    }
    function getName(){
        return "MySQL";
    }
}
class PostgreSQL implements NetworkStorage{
    function connect(){
     throw new ServerLoadException("Severload Eroore",201);
    }
    function getName(){
        return " PostgreSQL";
    }
}
class MSSQL implements NetworkStorage{
    function connect(){
    //throw new DiskFullException();
    return $this;
    }
    function getName(){
        return "MSQUL";
    }
}

class ConnectPull{
    protected $storage;
    protected $connection;
    function __construct(){
     $this->storage =  [];
    }
    function addStorage(NetworkStorage $storage){
        array_push($this->storage, $storage);
    }
    function getConnection(){
        foreach($this->storage as  $storage){
            try{
             $this->connection =  $storage->connect();  
            }catch(NetworkException $e){
               echo $storage->getName()." {$e->getCode()}: Has Network Related Problem\n"; 
            }catch(ServerLoadException $e){
               echo $storage->getName()."  {$e->getCode()}:Has Server Loading Related Problem\n";
            }catch(DiskFullException $e){
              echo $storage->getName()." Has Diskfull, trying to erase something\n";
            }
            if($this->connection){
                break;
            }
        }
        if($this->connection){
            return $this->connection;
        }
        return false;
    }
}

$mysql = new MySQL;
$pgsql = new PostgreSQL;
$mssqul = new MSSQL;

$cp = new ConnectPull;
$cp->addStorage($mysql);
$cp->addStorage($pgsql);
$cp->addStorage($mssqul);

$connection = $cp->getConnection();
print_r($connection);