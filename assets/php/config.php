
<?php
include_once 'contant.php';
class Database{
   
    private $dsn     = "mysql:host=localhost;dbname=user_system_db";
    private $dbuser = "root";
    private $dbpass  ="";

    public $conn;

    public function __construct(){

        try{
            $this->conn = new PDO($this->dsn,$this->dbuser,$this->dbpass);

           // echo 'Connected Successfully to the database';
        } catch (PDOException $e){
            echo 'Error :'.$e->getMessage();
        }
        return $this->conn;
    }
    
  // Utility function - check input
  public function test_input($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data  = htmlspecialchars($data);
      return $data;
  }

  // Utility function - Error, Success message Alert
  public function showMessage($type, $message){
      return '<div class="alert alert-'.$type.' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times</button>
                  <strong class="text-center">'.$message.'</strong>
              </div>';
  }

  //*****   Display time  in ago format ***  */
  public function timeInAgo($timestamp){
  
  date_default_timezone_set('Asia/Shanghai');
 
      $timestamp = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;
      $time = time() - $timestamp;

      switch($time){
          // Seconds
          case $time <= 60:
          return 'Just Now!';

          //Minutes
          case $time >= 60 && $time < 3600: // between 1 min and 1 hour
          return (round($time/60) == 1)? 'a minute ago' : round($time/60).' minutes ago';

          //Hours
          case $time >= 3600 && $time < 86400: // between 1 hour and < 1 day
          return (round($time/3600) == 1)? 'an hour ago' : round($time/3600).' hours ago';

          //Days
          case $time >= 86400 && $time < 604800:  // between a day and < 1 week
            return (round($time/86400) == 1)? 'an day ago' : round($time/86400).' days ago';

            //Weeks
            case $time >= 60480 && $time < 2600640 : // between a week and < a month
                return (round($time/60480) == 1)? 'a week ago' : round($time/60480).' weeks ago';

            // Months
            case $time >= 2600640 && $time < 31207680 : // between a month and < a year
                return (round($time/2600640) == 1)? 'a month ago' : round($time/2600640).' months ago';

            // Years
            case $time >= 31207680 : // between a year and above 
                return (round($time/31207680) == 1)? 'a year ago' : round($time/31207680).' years ago';

              }
    
    
    
      }
}

//$obj = new Database();

?>