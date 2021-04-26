<?php 
/**
 *  Security 
 * 
 *  - This class handles the main control for user permissions.
 *  - Redirects users etc.
 */
Class Security {
  /**
   *  initilizes global variables, check if session variables are set if not do so.
   */
  function __construct() {
    session_start();
    include_once('../config.php');
  
    if(empty($_SESSION['SAUCE']))
      foreach($config as $key => $val )
        $_SESSION[$key] = $val;
  }

  /**
   *  [loginAttempt - Handles passing request to model, and error processing ]
   * @param [STRING] - $email
   * @param [STRING] - $password
   * @return Redirect || Crash
   * 
   * TODO:: Instead of crash it should really show a 404 custom message and track it
   * 
   */
  public function loginAttempt(string $email, string $password) {

    if(empty($email) || empty($password))
      return [
        'status'  => 'error',
        'message' => 'Please enter both email and password.'
      ];
     
    require_once('User.php');
    $user   = New User();
    $result = $user->attemptLogin($email, $password);

    if($result) {
      $userID = $user->getUserId($email);
      $this->setSession('userID', $userID);
      $this->escort('dashboard');
      die();
    }
    $this->escort('/login?error');    
    exit;
  }

  /**
   * [gFname - Handles requesting the users fname]
   * @return [STRING] 
   */
  public function getFname() {
    require_once('User.php');
    $user   = New User();
    $fName = $user->getFname($_SESSION[$_SESSION['SAUCE']]['userID']);

    return $fName;
  }

  /**
   * [escort - Handles redirecting user to approiate pages]
   * 
   * @param - [STRING] - $page
   * 
   */
  public function escort($page, $status = NULL) {

    if($page == '/login')
      header('Location: /public/login.php'); 
      
    $userId = isset($_SESSION['userID']) ? $_SESSION['userID'] : 'default';

    //Note:: If I was doing a larger indepth project additional logic would be
    //added here
    if(!isset($_GET['page']))
      header('Location: /public/login.php'); 
      
    switch($page) {
      case('dashboard') :
        header('Location: /pages/dashboard.php'); 
      break;
      case('add-restaurant'):
        $get = '';
        if(isset($status)){
          $get = $status == 'SUCCESS'
            ? 'status=' .$status 
            : 'status=' .$status.'&message=' .$message;
        }          
        header('Location: /pages/add-restaurant.php'.$get); 
      break;
      case('register'):
        header('Location: /pages/add-review.php'); 
      break;
      case('add-review'):
        $get = '';
        if(isset($status) ){
          $get = ($status == 'SUCCESS') 
            ? 'status=' .$status 
            : 'status=' .$status.'&message=' .$message;
        }
        header('Location: /pages/add-review.php' .$get); 
        die();
      break;
      default:
        header('Location: /public/login.php'); 
      break;
    }
  }

  /**
   * [registerStatus - handles redirecting user post registration]
   * @param [BOOL]    - $status
   * @param [String]  - $message
   */
  public function registerStatus($status, $message = null) {
    ($status) 
      ? header('Location: /public/login.php?register=success')
      : header('Location: /public/login.php?register=fail&' .$message); 

    die();
  }

  /**
   * [registerStatus - handles redirecting user post registration]
   * @param [BOOL]    - $status
   * @param [String]  - $message
   */
  public function addSuccess($status, $page, $message = null) {
    ($status) 
      ? header("Location: /pages/$page.php?status=success")
      : header('Location: /pages/$page.php?status=fail&' .$message); 

    die();
  }

  /**
   * [securityCheck - Checks for incorrect access]
   */
  public function securityCheck(){
    if(!isset($_SESSION[$_SESSION['SAUCE']]['userID'])){
      $this->bounceThem();
    }
  }

  /**
   *  [bounceThem - Handles destroying sessions and logging users out]
   */
  public function bounceThem() {
    session_destroy();
    exit(header('Location: /public/index.php')); 
    die();
  }

  /**
   *  [serviceRequest - Handles form submission requests within the app ]
   * 
   */
  public function serviceRequest( string $request, $variables, User $user = NULL) {
    switch($request){
      case 'addReview':
        require_once('Restaurant.php');
        $resturant = new Restaurant();
        $return = $resturant->createNewReview($variables);

        ($return)
          ? $this->addSuccess(true, 'add-review')
          : $this->addSuccess(false,'add-review', $return['message']);                       
      break;
      case 'addRestaurant':
        require_once('Restaurant.php');
        $resturant = new Restaurant();
 
        $return = $resturant->createNewRestaurant($variables);

        ($return)
          ? $this->addSuccess(true, 'add-restaurant')
          : $this->addSuccess(false, 'add-restaurant', $return['message']);         
      break;
      case 'register':
        require_once('User.php');
        $user = new User();
        $return = $user->attemptRegister($variables);
        ($return)
        ? $this->registerStatus(true)
        : $this->registerStatus(false, $return['message']);         
      break;
      default:
        return false;
      break;
    }
    die();
  }

  public function hasPermission($user) {
    return false;
  }

  /**
   *  [setSession - Handles setting session variables in tandem with the secret sauce]
   * @param $key 
   * @param $value
   */
  private function setSession($key, $value) {
    try {      
      $_SESSION[$_SESSION['SAUCE']][$key] = $value;
    } catch (Exception $ex) {
      error_log("Setting Session Error: " .$ex->message(), 0);
      return false;
    }
    return true;
  }

}