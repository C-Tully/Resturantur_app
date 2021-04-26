<?php
  include('../models/Security.php');
  $security = new Security();
  $security->securityCheck();
  include_once('../models/Restaurant.php');
  $restaurants = new Restaurant;
  $restaurants = $restaurants->getNamesAndID();
  
  include('components/shared/header-private.inc.php');
?>
<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <?php include('components/shared/sidebar.inc.php'); ?>
  <!-- /#sidebar-wrapper -->
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="section-header"></div>
    <div class="container-fluid">
      <h2>Add a review!</h2>
      <?php include('components/shared/message-bubble.inc.php'); ?>
      <form action="/public/index.php?page=add-review" method="post" name="add-review">
        <input type="hidden" name="addReview" value="addReview" />
        <div class="form-group">
          <label for="exampleInputEmail1">Restaurant Name</label>
          <select name="restaurant_id" required>
            <?php foreach ($restaurants as $restaurant): ?>
            <option value="<?php echo $restaurant['restaurant_id']; ?>"><?php echo $restaurant['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Your Review</label>
          <textarea name="review_text" required class="form-control" placeholder="Write your review!"
            id="exampleInputPassword1"></textarea>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" name="status" class="form-check-input">
          <label class="form-check-label" for="exampleCheck1">Check to make post public. Hidden by default.</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

</div>
<!-- /#page-content-wrapper -->
</div>
<?php
  include('footer-private.php');
?>