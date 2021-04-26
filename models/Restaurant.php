<?php 
defined('SECRETSAUCE') or die("Access Denied."); 

Class Restaurant {

  CONST SUCCESS = TRUE;
  const FAIL = FALSE;
  /**
   * [getReviews - Gets all reviews]
   */
  public function getReviews() {
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
      $userID = $_SESSION[$_SESSION['SAUCE']]['userID'];
  
      $result = $mysqli->query("SELECT rest.name AS restaurantName,
          rest.restaurant_id,
          rest.created_at as createdAt,
          rev.status,
          rev.review as review,
          rev.submitter_id
        FROM
          restaurant rest
          LEFT JOIN reviews rev ON rev.restaurant_id = rest.restaurant_id
        WHERE
          rev.status = 1
          AND rev.submitter_id != '$userID'
        UNION (
          SELECT
            rest.name       AS restaurantName,
            rest.restaurant_id,
            rest.created_at AS createdAt,
            rev.status      AS reviewStat,
            rev.review      AS review,
            rev.submitter_id
          FROM
            restaurant rest
          LEFT JOIN reviews rev 
            ON rev.restaurant_id = rest.restaurant_id
        WHERE
          rev.submitter_id = '$userID')
          ");
      $reviews = [];

      while($row = $result->fetch_assoc()) 
        $reviews[] = $row;
      
    } 
    catch(Exception $ex) {

    }

    return $reviews;

  }

  /**
   * 
   */
  public function createNewRestaurant($variables) {
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
      $userID        = $_SESSION[$_SESSION['SAUCE']]['userID'];
      $restaurant_id  = md5(round(microtime(true) * 1000));;
      $name = $mysqli->real_escape_string($variables['name']);
  
      if ($mysqli->query("INSERT INTO restaurant (
          name,
          restaurant_id,
          edited_by
        ) 
        VALUES (
          '$name',
          '$restaurant_id',
          '$userID'
        )
      ")) {
        return [
          'status'  => self::SUCCESS,
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

  /**
   * [getNamesAndID - Handles retreiving all resturant names and Ids]
   * @return [ARRAY] 
   */
  public function getNamesAndID() {
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
      $result = $mysqli->query("SELECT DISTINCT *
        FROM restaurant 
        WHERE deleted_at IS NULL           
      ");
      $restaurants = [];

      while($row = $result->fetch_assoc()) 
        $restaurants[] = $row;
    } 
    catch(Exception $ex) {
      error_log("DB Register Error: " .$ex->message(), 0);
    }

    return $restaurants;
  }

  /**
   * [createNewReview - Handles creating a new review]
   * @param [ARRAY] $variables
   */
  public function createNewReview($variables) {

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
      $userID   = $_SESSION[$_SESSION['SAUCE']]['userID'];
      $restaurant_id  = $variables['restaurant_id'];
      $status = ( isset($variables['status']) ? 1 : 0);
      $review = $mysqli->real_escape_string($variables['review_text']);

      if ($mysqli->query("INSERT INTO reviews (
          review,
          restaurant_id,
          status,
          submitter_id
        ) 
        VALUES (
          '$review',
          '$restaurant_id',
          '$status',
          '$userID'
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

  /**
   *  [searchByKeyletter - handles searching the database for keyword matching on the closest find.]
   *  @param  - [STRING] - Letter or Keyword being entered at the time
   *  @return - [ARRAY]  - First found return package
   */
  public function searchByKeyletter($keyword) {
    try {
      $mysqli = new mysqli(
        $_ENV['DBURL'], 
        $_ENV['my_user'], 
        $_ENV['my_password'], 
        $_ENV['world']
      );
    } catch (Exception $ex) {
      error_log("DB Register Error: " .$ex->message(), 0);
    }

  }
}