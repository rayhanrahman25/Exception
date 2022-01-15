<?php
class NetworkException extends Exception{};
class ServerLoadException extends Exception{};
class DiskFullException extends Exception{};
interface Networkstoragee{
    function connection();
    function getName();
}
class MySQL implements Networkstoragee{
 function connection(){
   throw new NetworkException('Has Network Related Porblem, try to solve as soon as possible');
 }
 function getName(){
   return "MySQL";
 }
}
class PostgreSQL implements Networkstoragee{
 function connection(){
    throw new ServerLoadException ('Facing Server Loaded Problem, try To connect DevOps Eng.');
 }
 function getName(){
   return "PostgreSQL";
 }
}
class MSSQL implements Networkstoragee{
 function connection(){
  throw new DiskFullException('Erase Some Data, Disk Full Alrady');
 }
 function getName(){
   return " MSSQL";
 }
}
class ConnectPull{
       protected $storage;
       protected $connection;

       function __construct(){
        $this->storage = array();
       }
      function addStorage($storage){
        array_push($this->storage, $storage);
      }
     function letsConnected(){
         foreach($this->storage as $storage){
             try{
                $this->connection = $storage->connection();
             }catch(NetworkException $e){
                 echo $storage->getName().": {$e->getMessage()}\n";
             }catch(ServerLoadException $e){
                 echo $storage->getName().": {$e->getMessage()}\n";
             }catch(DiskFullException $e){
                 echo $storage->getName().": {$e->getMessage()}\n";
             }
             
         }
     }
}

$mysql = new MySQL;
$pgsql = new PostgreSQL;
$msqul = new  MSSQL;

$cp = new ConnectPull;
$cp->addStorage($mysql);
$cp->addStorage($pgsql);
$cp->addStorage($msqul);
$cp->letsConnected();

