<?php  if( isset($_GET['status']) && $_GET['status'] == 'success'): ?> 
  <div class="alert alert-success" role="alert" style="max-width:300px;">
    <p style="text-align:center;">Success.</p>
  </div>
<?php endif; ?>
<?php  if( isset($_GET['status']) && $_GET['status'] == 'error'): ?> 
  <div class="alert alert-primary" role="alert" style="max-width:300px;">
    <p style="text-align:center;"><?php echo $_GET['message']; ?></p>
  </div>
<?php endif;?>


