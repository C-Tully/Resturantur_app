<?php
  include('../models/Security.php');
  $security = new Security();
  $security->securityCheck();
  include_once('../models/Restaurant.php');
  $reviews = new Restaurant;
  $reviews = $reviews->getReviews();
  include('components/shared/header-private.inc.php');
?>
<div class="d-flex" id="wrapper">
  <?php include('components/shared/sidebar.inc.php'); ?>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="section-header"></div>
    <div class="container-fluid">
      <h2> <i><?php echo $security->getFname() ?></i> this is your feed!</h2>
      <div class="accordion" id="accordionExample">
        <?php $counter = 0; ?>
        <?php foreach($reviews as $review): ?>

        <div class="card" data-count="<?php echo $counter ?>">

          <div class="card-header" id="headingOne">
            <button class="btn btn-primary" type="button" data-toggle="collapse"
              data-target="#item-<?php echo $counter; ?>" aria-expanded="false" aria-controls="collapseExample" style="
              display: inline-block;
              width: 200px;">
              open / close
            </button>
            <h2 class="mb-0">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                <?php echo $review['restaurantName'] ?>
              </button>
            </h2>
          </div>
          <div class="collapse" id="item-<?php echo $counter; ?>">
            <div class="card card-body">
              <?php echo $review['review'] ?>
            </div>
          </div>
          <?php $counter++; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Menu Toggle Script -->
<script>
  $("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  // $(".card-header").click(function() {
  //   var count = this.data('count');

  //   $(".collapse[data-counter="+count).collapse();
  // });

  // $('.collapse').collapse()
  // $()
</script>



<?php
  include('components/shared/footer-private.inc.php');
?>