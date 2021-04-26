<?php
  include('../models/Security.php');
  $security = new Security();
  include_once('../models/Restaurant.php');
  $reviews = new Restaurant;
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
      <h2>Add your restaurant!</h2>
      <?php include('components/shared/message-bubble.inc.php'); ?>
      <div class="accordion" id="accordionExample">
        <form action="/public/index.php?page=add-restaurant" method="post" name="add-restaurant">
          <input type="hidden" name="addRestaurant" value="addRestaurant" />
          <div class="form-group">
            <label for="exampleInputEmail1">Restaurant Name</label>
            <input type="text" name="name" class="form-control" aria-describedby="restaurantName"
              placeholder="Restaurant Name" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /#page-content-wrapper -->
</div>
<?php
  include('footer-private.php');
?>