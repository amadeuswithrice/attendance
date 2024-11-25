<?php
// Auth check
$user_id = $_SESSION['admin_id'] ?? null;
$user_name = $_SESSION['name'] ?? null;
$security_key = $_SESSION['security_key'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;

// Redirect to login if not authenticated
if ($user_id === null || $security_key === null) {
    header('Location: index.php');
    exit(); // Ensure no further code is executed
}

// Database connection
// Assuming $conn is the database connection object
// You should replace it with your actual database connection code

// Pagination settings
$limit_breaks = 5; // Number of entries to show per page
$page_breaks = isset($_GET["page_breaks"]) ? (int)$_GET["page_breaks"] : 1;  
$start_from_breaks = ($page_breaks - 1) * $limit_breaks;

// Fetch data based on user role
if ($user_role == 1) {
    // Admin: fetch all records
    $sql = "SELECT * FROM tbl_breaks ORDER BY id DESC LIMIT $start_from_breaks, $limit_breaks";
} else {
    // Non-admin: fetch only records related to the logged-in user
    $sql = "SELECT * FROM tbl_breaks WHERE user_id = $user_id ORDER BY id DESC LIMIT $start_from_breaks, $limit_breaks";
}

$result = $conn->query($sql);

// Get total number of records for pagination
$total_sql = $user_role == 1 ? "SELECT COUNT(*) FROM tbl_breaks" : "SELECT COUNT(*) FROM tbl_breaks WHERE user_id = $user_id";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records_breaks = $total_row[0];
$total_pages_breaks = ceil($total_records_breaks / $limit_breaks);

$page_name = "Breaks Management";
?>

<center><h3>Bio Breaks</h3></center>

<table class="table table-condensed table-custom">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Date</th>
            <th>Bio Remaining</th>
            <th>Bio Exceed</th>
            <?php if ($user_role == 1) { ?>
                <th>Action</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($result->num_rows > 0) {
            $serial = $start_from_breaks + 1;
            while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td hidden><?php echo $serial++; ?></td>
            <td hidden><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo date('Y-m-d h:i A', strtotime($row['date'])); ?></td>
            <td><?php echo $row['bio_in']; ?></td>
            <td><?php echo $row['bio_exceed']; ?></td>
            <?php if ($user_role == 1) { ?>
            <td>
                <a title="Delete" href="?delete_break=delete_break&id=<?php echo $row['id']; ?>" onclick="return check_delete();">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
            <?php } else { ?>
            <td></td>
            <?php } ?>
        </tr>
        <?php 
            }
        } else {
            echo '<tr><td colspan="7">No Data found</td></tr>';
        }
        ?>
    </tbody>
    
</table>
<div class="pagination-breaks">
    <ul class="pagination-breaks">
        <?php
        if ($page_breaks > 1) {
            echo "<li><a href='?page_breaks=".($page_breaks - 1)."'>Previous</a></li>";
        }

        for ($i = 1; $i <= min(3, $total_pages_breaks); $i++) {
            $current_page_number = $page_breaks + $i - 1;
            if ($current_page_number > $total_pages_breaks) break;

            if ($current_page_number == $page_breaks) {
                echo "<li class='active'><a href='?page_breaks=".$current_page_number."'>".$current_page_number."</a></li>";
            } else {
                echo "<li><a href='?page_breaks=".$current_page_number."'>".$current_page_number."</a></li>";
            }
        }

        if ($page_breaks < $total_pages_breaks) {
            echo "<li><a href='?page_breaks=".($page_breaks + 1)."'>Next</a></li>";
        }
        ?>
    </ul>
</div>

<style>
.pagination-breaks {
    display: flex;
    justify-content: center;
    padding: 10px 0;
}

.pagination-breaks ul {
    list-style-type: none;
    padding: 0;
}

.pagination-breaks ul li {
    display: inline;
    margin: 0 5px;
}

.pagination-breaks ul li a {
    text-decoration: none;
    padding: 5px 10px;
    color: #007bff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
}

.pagination-breaks ul li.active a {
    background-color: #007bff;
    color: #fff;
    border: 1px solid #007bff;
}

.pagination-breaks ul li a:hover {
    background-color: #0056b3;
    color: #fff;
}
</style>
