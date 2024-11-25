<?php
require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// check admin
$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
  header('Location: task-info.php');
}

$page_name="Admin";
include("include/header.php");
include("include/sidebar.php");

if(isset($_POST['add_new_admin'])){
  $error = $obj_admin->add_new_admin($_POST);
}

?>

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
    <?php if(isset($error)){ ?>
      <script type="text/javascript">
        $('#myModal').modal('show');
      </script>
      <?php } ?>
      <?php if($user_role == 1){ ?>
      <button class="btn btn-primary-custom btn-menu" data-toggle="modal" data-target="#myModal">Add New Admin</button>
      <?php } ?>
      <ul class="nav nav-tabs nav-justified nav-tabs-custom">
        <li class="active"><a href="manage-admin.php">Manage Admin</a></li>
        <li><a href="admin-manage-user.php">Manage Employee</a></li>
      </ul>
      <div class="gap"></div>
      <div class="table-responsive">
        <table class="table table-condensed table-custom">
          <thead>
            <tr>
              <th>Serial No.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Username</th>
               <th>Temp Password</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <?php 
                $sql = "SELECT * FROM tbl_admin WHERE user_role = 1";
                $info = $obj_admin->manage_all_info($sql);
                $serial  = 1;
                $total_expense = 0.00;
                while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
            ?>
            <tr>
              <td><?php echo $serial; $serial++; ?></td>
              <td><?php echo $row['fullname']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['username']; ?></td>
               <td><?php echo $row['temp_password']; ?></td>
              <td><a title="Update Admin" href="update-admin.php?admin_id=<?php echo $row['user_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;</td>
            </tr>
            <?php  } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title text-center">Add Admin Info</h2>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <?php if(isset($error)){ ?>
              <h5 class="alert alert-danger"><?php echo $error; ?></h5>
            <?php } ?>
            <form role="form" action="" method="post" autocomplete="off">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label text-p-reset">Fullname</label>
                  <div class="">
                    <input type="text" placeholder="Enter Admin Name" name="ad_fullname" list="expense" class="form-control input-custom" id="default" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label text-p-reset">Username</label>
                  <div class="">
                    <input type="text" placeholder="Enter Admin username" name="ad_username" class="form-control input-custom" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label text-p-reset">Email</label>
                  <div class="">
                    <input type="email" placeholder="Enter admin Email" name="ad_email" class="form-control input-custom" required>
                  </div>
                </div>
                <div class="form-group">
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-3">
                    <button type="submit" name="add_new_admin" class="btn btn-primary btn-sm rounded-0">Add admin</button>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn btn-default btn-sm rounded-0" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if(isset($_SESSION['update_user_pass'])){
  echo '<script>alert("Password updated successfully");</script>';
  unset($_SESSION['update_user_pass']);
}
include("include/footer.php");
?>
