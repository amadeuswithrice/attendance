<?php
require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

if (isset($_GET['delete_attendance'])) {
    $action_id = $_GET['aten_id'];
    $sql = "DELETE FROM attendance_info WHERE aten_id = :id";
    $sent_po = "attendance-info.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_punch_in'])) {
    $info = $obj_admin->add_punch_in($_POST);
}

if (isset($_POST['add_punch_out'])) {
    $obj_admin->add_punch_out($_POST);
}

$page_name = "Attendance";
include("include/header.php");
include("include/sidebar.php");
include("include/modaljs.php");

$limit = 10; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page = $_GET["page"]; 
} else { 
    $page = 1; 
}  
$start_from = ($page - 1) * $limit;

// Check if the user is clocked in
$sql = "SELECT * FROM attendance_info WHERE atn_user_id = $user_id AND out_time IS NULL";
$info = $obj_admin->manage_all_info($sql);
$num_row = $info->rowCount();
?>
<div class="wrapper">
<div class="row">
  <div class="col-md-12">
    <div class="well well-custom" style="position:static; max-height:auto;">
      <div class="row">
        <div class="col-md-8">
          <div class="btn-group">
            <?php if ($num_row == 0) { ?>
            <div class="btn-group">
              <form method="post" role="form" action="">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit" name="add_punch_in" class="btn btn-primary btn-lg rounded">Clock In</button>
              </form>
            </div>
            <?php } else { ?>
            <div class="btn-group">
              <form method="post" role="form" action="">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="aten_id" value="<?php echo $info->fetch(PDO::FETCH_ASSOC)['aten_id']; ?>">
                <button type="submit" name="add_punch_out" class="btn btn-danger btn-lg round-button">
                <i class="glyphicon glyphicon-time"></i> <span>Time Out</span>
                </button>
              </form>
            </div>
            <?php } ?>
          </div>

          <div class="btn-group">
            <button id="startTimerButton" type="button" class="btn btn-warning round-button" data-toggle="modal" data-target="#biobreak">
              <i class="glyphicon glyphicon-time"></i> 5 min
            </button>
          </div>
          <div class="btn-group">
            <button id="startTimerButton1" type="button" class="btn btn-primary round-button" data-toggle="modal" data-target="#shortbreak">
              <i class="glyphicon glyphicon-cutlery"></i> 15 min
            </button>
          </div>
          <div class="btn-group">
            <button id="startTimerButton3" type="button" class="btn btn-primary round-button" data-toggle="modal" data-target="#shortbreak30">
              <i class="glyphicon glyphicon-cutlery"></i> 30 min
            </button>
          </div>
          <div class="btn-group">
            <button id="startTimerButton4" type="button" class="btn btn-primary round-button" data-toggle="modal" data-target="#shortbreak45">
              <i class="glyphicon glyphicon-cutlery"></i> 45 min
            </button>
          </div>
          <div class="btn-group">
            <button id="startTimerButton2" type="button" class="btn btn-danger round-button" data-toggle="modal" data-target="#mealbreak">
              <i class="glyphicon glyphicon-cutlery"></i> 60 min
            </button>
          </div>
        </div>
      </div>

      <center><h3>Manage Attendance</h3></center>
      <div class="gap"></div>
      <div class="gap"></div>

      <div class="table-responsive">
        <table class="table table-condensed table-custom">
          <thead>
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>In Time</th>
              <th>Out Time</th>
              <th>Total Duration</th>
              <th>Status</th>
              <?php if ($user_role == 1) { ?>
              <th>Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
  <?php 
  if ($user_role == 1) {
    $sql = "SELECT a.*, b.fullname 
            FROM attendance_info a
            LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
            ORDER BY a.aten_id DESC
            LIMIT $start_from, $limit";
  } else {
    $sql = "SELECT a.*, b.fullname 
            FROM attendance_info a
            LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
            WHERE atn_user_id = $user_id
            ORDER BY a.aten_id DESC
            LIMIT $start_from, $limit";
  }

  $info = $obj_admin->manage_all_info($sql);
  $serial = $start_from + 1;
  $num_row = $info->rowCount();
  if ($num_row == 0) {
    echo '<tr><td colspan="7">No Data found</td></tr>';
  }
  while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
  ?>
  <tr>
    <td><?php echo $serial++; ?></td>
    <td><?php echo $row['fullname']; ?></td>
    <td><?php echo date("M d, Y g:i A", strtotime($row['in_time'])); ?></td>
    <td><?php echo $row['out_time'] ? date("M d, Y g:i A", strtotime($row['out_time'])) : ''; ?></td>
    <td>
  <?php
  // Fetch the in_time and out_time from the database for debugging
  $in_time = $row['in_time'];
  $out_time = $row['out_time'];
  
  echo "<!-- Debugging: in_time={$in_time}, out_time={$out_time} -->"; // Debugging log
  
  if ($out_time == null) {
    $dteStart = new DateTime($in_time, new DateTimeZone('Asia/Manila'));
    $dteEnd = new DateTime('now', new DateTimeZone('Asia/Manila'));
  } else {
    // If out_time is not null, calculate the duration between in_time and out_time
    $dteStart = new DateTime($in_time, new DateTimeZone('Asia/Manila'));
    $dteEnd = new DateTime($out_time, new DateTimeZone('Asia/Manila'));
  }
  
  // Calculate the difference
  $dteDiff = $dteStart->diff($dteEnd);
  
  // Debugging log for calculated difference
  echo "<!-- Debugging: dteDiff={$dteDiff->format('%H:%I:%S')} -->";
  
  // Format the interval to include leading zeros for hours, minutes, and seconds
  $hours = str_pad($dteDiff->h, 2, "0", STR_PAD_LEFT);
  $minutes = str_pad($dteDiff->i, 2, "0", STR_PAD_LEFT);
  $seconds = str_pad($dteDiff->s, 2, "0", STR_PAD_LEFT);
  echo "{$hours}:{$minutes}:{$seconds}";
  ?>
</td>

    <td class="text-center"><?php echo ($row['out_time'] == null) ? 'In Progress' : 'Completed'; ?></td>
    <?php if ($user_role == 1) { ?>
    <td>
      <a title="Delete" href="?delete_attendance=delete_attendance&aten_id=<?php echo $row['aten_id']; ?>" onclick="return check_delete();">
        <span class="glyphicon glyphicon-trash"></span>
      </a>
    </td>
    <?php } else { ?>
    <td></td>
    <?php } ?>
  </tr>
  <?php } ?>
</tbody>


        </table>
      </div>

      <!-- Pagination Controls -->
      <nav>
    <ul class="pagination">
        <?php 
        $sql = "SELECT COUNT(aten_id) FROM attendance_info";
        $info = $obj_admin->manage_all_info($sql);
        $row = $info->fetch(PDO::FETCH_NUM);
        $total_records = $row[0];
        $total_pages = ceil($total_records / $limit);

        $page_range = 3; // Number of pages to show on either side of the current page
        $start_page = max(1, $page - $page_range);
        $end_page = min($total_pages, $page + $page_range);

        // Previous Button
        if ($page > 1) {
            echo "<li><a href='attendance-info.php?page=" . ($page - 1) . "'>&lt;</a></li>";
        }

        // Page Numbers
        for ($i = $start_page; $i <= $end_page; $i++) { 
            if ($i == $page) {
                echo "<li class='active'><a href='attendance-info.php?page=" . $i . "'>" . $i . "</a></li>";
            } else {
                echo "<li><a href='attendance-info.php?page=" . $i . "'>" . $i . "</a></li>";
            }
        }

        // Next Button
        if ($page < $total_pages) {
            echo "<li><a href='attendance-info.php?page=" . ($page + 1) . "'>&gt;</a></li>";
        }
        ?>
    </ul>
</nav>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="well well-custom" style="position:static; max-height:auto;">
      <div class="row">
        <div class="col-md-8">
<div class="table-responsive">
    <div class="row">
        
    <div class="col-md-4">       
           <?php 
           include("breaks/view_bio.php");
           ?>
           
        </div>
       </div>
       

        <div class="col-md-4" hidden>
            <?php
            include ("breaks/view_fifth.php");
            ?>
        </div>
</div>
        <div class="col-md-4" hidden>
            <center><h3>Manage 30 Minute Breaks</h3></center>
            <table class="table table-condensed table-custom" hidden>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Bio In</th>
                        <th>Exceeding Time</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Pagination here</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="table-responsive" hidden>
    <div class="row">
        <div class="col-md-6">
            <center><h3>Manage Bio Breaks</h3></center>
            <table class="table table-condensed table-custom">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Bio In</th>
                        <th>Exceeding Time</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Pagination here</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <center><h3>Manage 15 Minute Breaks</h3></center>
            <table class="table table-condensed table-custom">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Bio In</th>
                        <th>Exceeding Time</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Pagination here</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td>Cell</td>
                        <td>Cell</td>
                    </tr>
                </tbody>
            </table>
</div>
</div>
</div>
</div>
</div>



<?php include("include/footer.php"); ?>

