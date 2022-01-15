<?php

class Bio{
    function __construct($name, $age){
      $this->name = $name;
      if($age>=12){
          throw new Exception('Too Older For Admission',1210);
      }elseif($age<=4){
          throw new Exception('Too Young For Addmission',104);
      }
      $this->age = $age;  
    }
}
try{
   $bio = new Bio('Rayhan',5);
   echo "Ready To Admission ? Don't be Late Do it now";
}catch(Exception $e){
    echo $e->getCode().":".$e->getMessage();
}
