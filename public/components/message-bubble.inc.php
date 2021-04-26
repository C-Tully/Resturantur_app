<?php  if( isset($_GET) && $_GET['register'] == 'success'): ?> 
  <div class="alert alert-success" role="alert">
    <p style="text-align:center;">Success, please login.</p>
  </div>
<?php endif; ?>
<?php  if( isset($_GET) && $_GET['register'] == 'error'): ?> 
  <div class="alert alert-primary" role="alert">
    <p style="text-align:center;"><?php echo $_GET['message']; ?></p>
  </div>
<?php endif;?>


