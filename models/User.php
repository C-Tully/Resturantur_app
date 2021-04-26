<?php 
defined('SECRETSAUCE') or die("Access Denied users."); 

/**
 * @author Christopher Tully  - christully12@gmail.com
 * 
 *  
 * 
 * 
 */
Class User {

const FAIL    = FALSE;
const SUCCESS = TRUE;

  /**
   *  [loginAttempt - Handles verifying if user exists in db]
   * @param   [STRING] - $email
   * @param   [STRING] - $password
   * @return  [BOOL] 
   */
  public function attemptLogin($email, $password) {
    try {
      $mysqli = new mysqli(
        $_SESSION['DBURL'], 
        $_SESSION['DBUSERNAME'],
        $_SESSION['DBPASS'], 
        $_SESSION['DBNAME']
      );
      
      /* check connection */
      if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }

    } catch (Excepton $ex) {
      error_log("Database Not available: Error: " .$ex->message(), 0);
      return self::FAIL;
    }

    $salt = $_SESSION['SAUCE'];
    try {
      $email    = $mysqli->real_escape_string($email);
      
      $result = $mysqli->query("SELECT COUNT(userID) 
        FROM users 
        WHERE email = '$email'
      ");

      $row = $result->fetch_row();
      
      if($row[0] <= 0)
        return self::FAIL;

        $result = $mysqli->query("SELECT userPassword
        FROM users 
        WHERE email = '$email'
      ");

      $row = $result->fetch_row();
      $mysqli->close();

      $dbPwd = $row[0];
      
      if(password_verify($password,$dbPwd))
        return self::SUCCESS;
      
    } catch (Exception $ex) {
      error_log("Query Error: " .$ex->message(), 0);
      return self::FAIL;
    }

    return self::FAIL;
  }

  public function getFname($userID) {
    try{
      $mysqli = new mysqli(
        $_SESSION['DBURL'], 
        $_SESSION['DBUSERNAME'],
        $_SESSION['DBPASS'], 
        $_SESSION['DBNAME']
      );

    /* check connection */
    if ($mysqli->connect_errno) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }

  } catch (Excepton $ex) {
    error_log("Database Not available: Error: " .$ex->message(), 0);
    return self::FAIL;
  }
  
  try {
    //User is validated at this time, we just need userID
    $result = $mysqli->query("SELECT fname
      FROM users 
      WHERE userID = '$userID'
    ");

    $row    = $result->fetch_row();
    $fName = !empty($row[0]) ?  $row[0] : self::FAIL;
    $mysqli->close();
    return $fName;

  } catch (Exception $ex) {
    error_log("Query Error: " .$ex->message(), 0);      
  }
  return self::FAIL;
  }

  /**
   *  getUserId - Handles getting the supplied emails userID
   * 
   * @param  [STRING] - $email 
   * @return [STRING || BOOL] 
   */
  public function getUserId($email) {
    try {
      $mysqli = new mysqli(
        $_SESSION['DBURL'], 
        $_SESSION['DBUSERNAME'],
        $_SESSION['DBPASS'], 
        $_SESSION['DBNAME']
      );
  
      /* check connection */
      if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }
  
    } catch (Excepton $ex) {
      error_log("Database Not available: Error: " .$ex->message(), 0);
      return self::FAIL;
    }
    $email    = $mysqli->real_escape_string($email);
    try {
      //User is validated at this time, we just need userID
      $result = $mysqli->query("SELECT userID
        FROM users 
        WHERE email = '$email'
      ");
 
      $row    = $result->fetch_row();
      $userID = !empty($row[0]) ?  $row[0] : self::FAIL;
      $mysqli->close();
      return $userID;

    } catch (Exception $ex) {
      error_log("Query Error: " .$ex->message(), 0);      
    }
    return self::FAIL;
  }

  /**
   *  [attemptRegister - Handles storing and registering a users data]
   * @param [ARRAY] - $variables 
   * @return [ARRAY] - success
   *                 - message
   */
  public function attemptRegister($variables) {
    try {
      $mysqli = new mysqli(
        $_SESSION['DBURL'], 
        $_SESSION['DBUSERNAME'],
        $_SESSION['DBPASS'], 
        $_SESSION['DBNAME']
      );
      
      /* check connection */
      if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }

    } catch (Excepton $ex) {
      error_log("Database Not available: Error: " .$ex->message(), 0);
      return self::FAIL;
    }

    try {    
  
      $email  = $mysqli->real_escape_string($variables['email']);
      $result = $mysqli->query("SELECT COUNT(user_id) 
        FROM users 
        WHERE email = $email
      ");

      $row = (!$result ? $result : $result->fetch_row());
      if( $row[0] > 0 )
        return [
          'status'  => 'error',
          'message' => 'This email is already in use. Please enter '
        ];

      $register_password = $variables['password'];
      $password = password_hash(
        $register_password,
        PASSWORD_BCRYPT
      );

      $userID   = md5(round(microtime(true) * 1000));
      $fName    = $mysqli->real_escape_string($variables['fname']);
      $lName    = $mysqli->real_escape_string($variables['lname']);
      $userName = $mysqli->real_escape_string($variables['username']);
    
      if ($mysqli->query("INSERT INTO users (
          userID,
          fname,
          lname,
          username,
          email,
          userPassword
        ) 
        VALUES (
          '$userID',
          '$fName',
          '$lName',
          '$userName',
          '$email',
         '$password'
        )
      ")) {
        return [
          'status' => self::SUCCESS,
          'message' => ''
        ];
      }

      else {
        return [
          'status'  => self::FAIL,
          'message' => 'We\'re sorry but we are unable to register you at this time,
                          please check back in a couple of minuites.'
        ];
      }
      
      $mysqli->close();

    } catch (Exception $ex) {
      error_log("DB Register Error: " .$ex->message(), 0);
    }
    return [
      'status'  => self::FAIL,
      'message' => 'We\'re sorry but we are unable to register you at this time,
                    please check back in a couple of minuites.'
    ];
  }
}

