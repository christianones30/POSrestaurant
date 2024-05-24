<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['addPackage'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["pack_code"]) || empty($_POST["pack_name"]) || empty($_POST['pack_desc']) || empty($_POST['pack_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $pack_id = $_POST['pack_id'];
    $pack_code  = $_POST['pack_code'];
    $pack_name = $_POST['pack_name'];
    $pack_img = $_FILES['pack_img']['name'];
    move_uploaded_file($_FILES["pack_img"]["tmp_name"], "assets/img/package/" . $_FILES["pack_img"]["name"]);
    $pack_desc = $_POST['pack_desc'];
    $pack_price = $_POST['pack_price'];
	//Visit codeastro.com for more projects
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO rpos_inventory (pack_id, pack_code, pack_name, pack_img, pack_desc, pack_price ) VALUES(?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssss', $pack_id, $pack_code, $pack_name, $pack_img, $pack_desc, $pack_price);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "packuct Added" && header("refresh:1; url=add_package.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header --><!-- For more projects: Visit codeastro.com  -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
    <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div><!-- For more projects: Visit codeastro.com  -->
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3>Please Fill All Fields</h3>
            </div><!-- For more projects: Visit codeastro.com  -->
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>packuct Name</label>
                    <input type="text" name="pack_name" class="form-control">
                    <input type="hidden" name="pack_id" value="<?php echo $pack_id; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>packuct Code</label>
                    <input type="text" name="pack_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                  </div>
                </div>
                <hr><!-- For more projects: Visit codeastro.com  -->
                <div class="form-row">
                  <div class="col-md-6">
                    <label>packuct Image</label>
                    <input type="file" name="pack_img" class="btn btn-outline-success form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>packuct Price</label>
                    <input type="text" name="pack_price" class="form-control" value="">
                  </div>
                </div>
                <hr><!-- For more projects: Visit codeastro.com  -->
                <div class="form-row">
                  <div class="col-md-12">
                    <label>packuct Description</label>
                    <textarea rows="5" name="pack_desc" class="form-control" value=""></textarea>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addPackage" value="Add ingredients" class="btn btn-success" value="">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- For more projects: Visit codeastro.com  -->
      <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>
<!-- For more projects: Visit codeastro.com  -->
</html>