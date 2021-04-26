<?php 
include('../models/Security.php');

$security = new Security();
defined('SECRETSAUCE') or die("Access Denied index."); 

if(isset($_GET['page']) && $_GET['page'] === 'logout'){
  $security->bounceThem();
  exit();
}
if(!isset($_GET['page']) && empty($_GET['page']))
  $security->escort('/login');


switch($_GET['page']) {

  case 'login':
    //todo:: add csrf validation
    if(!empty($_POST['login']))
      $security->loginAttempt($_POST['email'], $_POST['password']);  
    else
      $security->escort('/login');
  break;
  case 'register':
    $security->serviceRequest(
      'register', 
      $_POST    
    );      
  break;
  case 'dashboard':
    $security->escort('dashboard');
  break;
  case 'add-restaurant':

    if(!empty($_POST['addRestaurant']))    
      $security->serviceRequest(
        'addRestaurant',
        $_POST          
      );      
    else       
      $security->escort('add-restaurant');
  break;
  case 'add-review':    
    if(!empty($_POST['addReview']))   {
      $review_text = $_POST['review_text'];
      $security->serviceRequest(
        'addReview', 
        $_POST
      );      

    }     
    else
      $security->escort('add-review');
  break;
  default:
    $security->escort('/login');
    die();
  break;
}

