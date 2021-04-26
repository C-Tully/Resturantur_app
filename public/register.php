<?php include('../pages/components/shared/header-public.inc.php'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-5 mx-auto">
      <div >
        <div class="myform form ">
          <div class="logo mb-3">
            <div class="col-md-12 text-center">
              <h1>Signup</h1>
            </div>
          </div>
          <form action="index.php?page=register" method="post" name="registration">
            <input type="hidden" name="page" value="register">
            <div class="form-group">
              <label for="exampleInputEmail1">First Name</label>
              <input type="text" name="fname" class="form-control" id="firstname" aria-describedby="emailHelp"
                placeholder="Enter Firstname">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Last Name</label>
              <input type="text" name="lname" class="form-control" id="lastname" aria-describedby="emailHelp"
                placeholder="Enter Lastname">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" name="email" class="form-control"  aria-describedby="emailHelp"
                placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
                <input type="text" name="username" class="form-control" aria-describedby="emailHelp"
                  placeholder="Enter Username">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Password</label>
              <input type="password" name="password" id="password" class="form-control" aria-describedby="emailHelp"
                placeholder="Enter Password">
            </div>
            <div class="col-md-12 text-center mb-3">
              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Get Started For Free</button>
            </div>
            <div class="col-md-12 ">
              <div class="form-group">
                <p class="text-center"><a href="#" id="signin">Already have an account?</a></p>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include('../pages/components/shared/footer-public.inc.php'); ?>
