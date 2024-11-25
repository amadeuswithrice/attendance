<?php 
if (isset($_SERVER['HTTPS'])) {
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$base_url = $protocol . "://" . $_SERVER['SERVER_NAME'] . '/' . explode('/', $_SERVER['PHP_SELF'])[1] . '/';
?>
<?php
require 'authentication.php'; // admin authentication check 

// auth check
$user_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : null;
$security_key = isset($_SESSION['security_key']) ? $_SESSION['security_key'] : null;
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
    exit;
}

// check admin
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

if (isset($_GET['delete_task'])) {
    $action_id = $_GET['task_id'];

    $sql = "DELETE FROM task_info WHERE task_id = :id";
    $sent_po = "task-info.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

if (isset($_POST['add_task_post'])) {
    $obj_admin->add_new_task($_POST);
}

$page_name = "Daily-Attendance-Report";
include("include/header.php");
include("include/sidebar.php");
// include('ems_header.php');

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$name = isset($_GET['name']) ? $_GET['name'] : '';
$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';
?>

<div class="row">
    <div class="col-md-12">
        <div class="well well-custom rounded-0">
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-3">
                    <label for="Start Date">Start Date</label>
                    <input type="date" id="start_date" value="<?= $start_date ?>" class="form-control rounded-0">
                </div>
                <div class="col-md-3">
                    <label for="End Date">End Date</label>
                    <input type="date" id="end_date" value="<?= $end_date ?>" class="form-control rounded-0">
                </div>
                <div class="col-md-3">
                    <label for="Search Name">Search Name</label>
                    <input type="text" id="name" value="<?= $name ?>" placeholder="&#128269; Search Name" class="form-control rounded-0"><br><br>
                </div>
                <div class="col-md-3" hidden>
                    <input type="time" id="start_time" value="<?= $start_time ?>" placeholder="Start Time" class="form-control rounded-0">
                    <input type="time" id="end_time" value="<?= $end_time ?>" placeholder="End Time" class="form-control rounded-0">                    
                </div>
                <div class="col-md-3">
                    <label for="Branch">Branch</label>
                    <input type="text" id="branch" value="<?= $branch ?>" placeholder="Branch" class="form-control rounded-0">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm btn-menu" type="button" id="filter"><i class="glyphicon glyphicon-filter"></i></button>
                    <button class="btn btn-success btn-sm btn-menu" type="button" id="print"><i class="glyphicon glyphicon-print"></i></button>
                    <button class="btn btn-danger btn-sm btn-menu" type="button" id="export_csv"><i class="glyphicon glyphicon-export"></i></button>
                </div>				
            </div>
            <center><h3>Daily Attendance Report</h3></center>
            <div class="gap"></div>
            <div class="gap"></div>
            <div class="table-responsive" id="printout">
                <table class="table table-condensed table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Total Duration</th>
                            <th>Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
$sql = "SELECT a.*, b.fullname, b.branch 
FROM attendance_info a
LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id) 
WHERE (a.in_time BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59')";
if (!empty($name)) {
    $sql .= " AND b.fullname LIKE '%$name%'";
}
if (!empty($start_time)) {
    $sql .= " AND TIME(a.in_time) >= '$start_time'";
}
if (!empty($end_time)) {
    $sql .= " AND TIME(a.out_time) <= '$end_time'";
}
if (!empty($branch)) {
    $sql .= " AND b.branch LIKE '%$branch%'";
}
$sql .= " ORDER BY a.aten_id DESC";

$info = $obj_admin->manage_all_info($sql);
$serial = 1;
$num_row = $info->rowCount();
if ($num_row == 0) {
    echo '<tr><td colspan="7">No Data found</td></tr>';
}
while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
    <td><?php echo $serial; $serial++; ?></td>
    <td><?php echo $row['fullname']; ?></td>
    <td><?php echo $row['in_time']; ?></td>
    <td><?php echo $row['out_time']; ?></td>
    <td><?php
        $dteStart = new DateTime($row['in_time']);
        if ($row['out_time'] == null) {
            $dteEnd = new DateTime('now', new DateTimeZone('Asia/Manila'));
        } else {
            $dteEnd = new DateTime($row['out_time']);
        }
        $dteDiff = $dteStart->diff($dteEnd);
        echo $dteDiff->format("%H:%I:%S");
    ?></td>
    <td><?php echo $row['branch']; ?></td>
</tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include("include/footer.php");
?>

<noscript>
    <div>
        <style>
            body{
                background-image:none !important;
            }
            .mb-0{
                margin:0px;
            }
        </style>
        <div style="line-height:1em">
            <h4 class="mb-0 text-center"><b>Employee Task Management System</b></h4>
            <h4 class="mb-0 text-center"><b>Daily Attendance Report</b></h4>
            <div class="mb-0 text-center"><b>as of</b></div>
            <div class="mb-0 text-center"><b><?= date("F d, Y", strtotime($start_date)) ?></b></div>
        </div>
        <hr>
    </div>
</noscript>

<script type="text/javascript">
$(function(){
    $('#filter').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var name = $('#name').val();
        var start_time = $('#start_time').val();
        var end_time = $('#end_time').val();
        var branch = $('#branch').val();

        var url = "./daily-attendance-report.php?start_date=" + start_date + "&end_date=" + end_date;
        if (name !== '') {
            url += "&name=" + name;
        }
        if (start_time !== '') {
            url += "&start_time=" + start_time;
        }
        if (end_time !== '') {
            url += "&end_time=" + end_time;
        }
        if (branch !== '') {
            url += "&branch=" + branch;
        }
        
        location.href = url;
    });

    $('#print').click(function(){
        var h = $('head').clone();
        var ns = $($('noscript').html()).clone();
        var p = $('#printout').clone();
        var base = '<?= $base_url ?>';
        h.find('link').each(function(){
            $(this).attr('href', base + $(this).attr('href'));
        });
        h.find('script').each(function(){
            if($(this).attr('src') != "") {
                $(this).attr('src', base + $(this).attr('src'));
            }
        });
        p.find('.table').addClass('table-bordered');
        var nw = window.open("", "_blank","width:"+($(window).width() * .8)+",left:"+($(window).width() * .1)+",height:"+($(window).height() * .8)+",top:"+($(window).height() * .1));
        nw.document.querySelector('head').innerHTML = h.html();
        nw.document.querySelector('body').innerHTML = ns[0].outerHTML;
        nw.document.querySelector('body').innerHTML += p[0].outerHTML;
        nw.document.close();
        setTimeout(() => {
            nw.print();
            setTimeout(() => {
                nw.close();
            }, 200);
        }, 200);
    });
});
</script>

<script>
$(function(){
    $('#export_csv').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var name = $('#name').val();
        var start_time = $('#start_time').val();
        var end_time = $('#end_time').val();
        var branch = $('#branch').val();

        var url = 'export_csv.php?start_date=' + start_date + '&end_date=' + end_date + '&name=' + name + '&start_time=' + start_time + '&end_time=' + end_time + '&branch=' + branch;
        
        window.location.href = url;
    });
});
</script>
