<?php

class DbOperation
{
    //Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

    //storing token in database 
    public function registerDevice($email,$token){
        if($this->isEmailExist($email) == 0){
            $sql1 = "INSERT INTO  devices (email,token) VALUES ('$email','$token')";
                  if(mysqli_query($this->con, $sql1)){
                    return 0;
                    //device registered
                  }
              }
          else if ($this->isEmailExist($email) == 1) {
            $u  = "UPDATE devices SET token = '$token' WHERE email = '$email'";
            if(mysqli_query($this->con, $u)){
                    return 2;
                                //device already registered  or updated 

              
                  }
            
          }
      }

            
                
            


        //     $stmt = $this->con->prepare("INSERT INTO devices (email, token) VALUES (?,?) ");
        //     $stmt->bind_param("ss",$email,$token);
        //     if($stmt->execute())
        //        //returning 2 means email already exist
        // }
    

    //the method will check if email already exist 
    private function isEmailexist($email){
        // $stmt = $this->con->prepare("SELECT id FROM devices WHERE email = ?");
        // $stmt->bind_param("s",$email);
        // $stmt->execute();
        // $stmt->store_result();
        // $num_rows = $stmt->num_rows;
        // $stmt->close();
        // return $num_rows > 0;

          $checkuser ="SELECT id FROM devices WHERE email = '$email'";
          $res =mysqli_query($this->con,$checkuser);
          if ($res) {
            if (mysqli_num_rows($res) == 1) {
                return 1;
            }
            //device already registered email exist
              
          }
          else {
              return 0;
          }
          
    }

    //getting all tokens to send push to all devices
    public function getAllTokens(){
        $stmt = $this->con->prepare("SELECT token FROM devices");
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['token']);
        }
        return $tokens; 
    }

    //getting a specified token to send push to selected device
    public function getTokenByEmail($email){
        $stmt = $this->con->prepare("SELECT token FROM devices WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute(); 
        $result = $stmt->get_result()->fetch_assoc();
        return array($result['token']);        
    }

    //getting all the registered devices from database 
    public function getAllDevices(){
        $stmt = $this->con->prepare("SELECT * FROM devices");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result; 
    }
}