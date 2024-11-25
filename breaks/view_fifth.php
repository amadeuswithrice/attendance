<?php


// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}



// Pagination settings
$limit = 5; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page = $_GET["page"]; 
} else { 
    $page = 1; 
}  
$start_from = ($page - 1) * $limit;

// Fetch data based on user role
if ($user_role == 1) {
    $sql = "SELECT * FROM tbl_break_second ORDER BY id DESC LIMIT $start_from, $limit";
} else {
    $sql = "SELECT * FROM tbl_break_second WHERE user_id = $user_id ORDER BY id DESC LIMIT $start_from, $limit";
}

$result = $conn->query($sql);

// Get total number of records for pagination
$total_sql = $user_role == 1 ? "SELECT COUNT(*) FROM tbl_break_second" : "SELECT COUNT(*) FROM tbl_break_second WHERE user_id = $user_id";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records = $total_row[0];
$total_pages = ceil($total_records / $limit);

$page_name = "Breaks Management";

?>


            <center><h3>15 Minute Breaks</h3></center>
            <div class="table-responsive">
                <table class="table table-condensed table-custom">
                    <thead>
                        <tr>
                            
                            <th>Full Name</th>
                            <th>Date</th>
                            <th>Second In</th>
                            <th>Second Exceed</th>
                            <?php if ($user_role == 1) { ?>
                                <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result->num_rows > 0) {
                            $serial = $start_from + 1;
                            while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td hidden><?php echo $serial++; ?></td>
                            <td hidden><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['secnd_in']; ?></td>
                            <td><?php echo $row['secnd_exceed']; ?></td>
                            <?php if ($user_role == 1) { ?>
                            <td>
                                <a title="Delete" href="?delete_break_second=delete_break_second&id=<?php echo $row['id']; ?>" onclick="return check_delete();">
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
            

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination">
                    <?php 
                    $page_range = 3; // Number of pages to show on either side of the current page
                    $start_page = max(1, $page - $page_range);
                    $end_page = min($total_pages, $page + $page_range);

                    // Previous Button
                    if ($page > 1) {
                        echo "<li><a href='breaks-second-management.php?page=" . ($page - 1) . "'>&lt;</a></li>";
                    }

                    // Page Numbers
                    for ($i = $start_page; $i <= $end_page; $i++) { 
                        if ($i == $page) {
                            echo "<li class='active'><a href='breaks-second-management.php?page=" . $i . "'>" . $i . "</a></li>";
                        } else {
                            echo "<li><a href='breaks-second-management.php?page=" . $i . "'>" . $i . "</a></li>";
                        }
                    }

                    // Next Button
                    if ($page < $total_pages) {
                        echo "<li><a href='breaks-second-management.php?page=" . ($page + 1) . "'>&gt;</a></li>";
                    }
                    ?>
                </ul>
            </nav>
            </div>