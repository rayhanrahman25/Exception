<?php
class MyException extends Exception{

}
class NetworkException extends Exception{

}

function myFunction(){
    throw new MyException();
}

try{
    myFunction();
}catch(MyException $e){
    echo "Myexcep tion Caught";
}catch(NetworkException $e){
    echo "NetworkExcetion Caught";
}catch(Exception $e){
    echo "Exception Caught";
}