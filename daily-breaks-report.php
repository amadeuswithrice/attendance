<?php
require 'authentication.php'; // Admin authentication check

// Check if Admin_Class.php is already included
if (!class_exists('Admin_Class')) {
    require_once 'classes/Admin_Class.php'; // Include Admin_Class if it hasn't been included before
}

// Instantiate Admin_Class
$obj_admin = new Admin_Class();

// Include necessary files
$user_name = $_SESSION['name'] ?? null;
include("include/header.php");
include("include/sidebar.php");

// Pagination variables
$limit = 10; // Number of entries to show in a page
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$start_from = ($page - 1) * $limit;

// Ensure $user_role is set correctly
$user_role = $_SESSION['user_role'] ?? null; // Adjust this according to how user role is stored in session

// Filter variables
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$fullname = isset($_GET['fullname']) ? $_GET['fullname'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';

try {
    // Prepare SQL query for fetching breaks based on user role with pagination
    $sql = "SELECT b.*, a.fullname 
            FROM tbl_breaks b
            INNER JOIN tbl_admin a ON b.user_id = a.user_id";

    // Apply filters if set
    $conditions = [];
    if (!empty($fullname)) {
        $conditions[] = "a.fullname LIKE :fullname";
    }
    if (!empty($start_date) && !empty($end_date)) {
        $conditions[] = "b.date BETWEEN :start_date AND :end_date";
    }
    if (!empty($branch)) {
        $conditions[] = "a.branch LIKE :branch";
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY b.date DESC
              LIMIT :start_from, :limit";

    $stmt = $obj_admin->getDb()->prepare($sql);
    if (!empty($fullname)) {
        $stmt->bindValue(':fullname', "%$fullname%", PDO::PARAM_STR);
    }
    if (!empty($start_date) && !empty($end_date)) {
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    }
    if (!empty($branch)) {
        $stmt->bindValue(':branch', "%$branch%", PDO::PARAM_STR);
    }
    $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $breaks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total number of records for pagination
    $count_sql = "SELECT COUNT(*) AS total FROM tbl_breaks b
                  INNER JOIN tbl_admin a ON b.user_id = a.user_id";

    if (!empty($conditions)) {
        $count_sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt_count = $obj_admin->getDb()->prepare($count_sql);
    if (!empty($fullname)) {
        $stmt_count->bindValue(':fullname', "%$fullname%", PDO::PARAM_STR);
    }
    if (!empty($start_date) && !empty($end_date)) {
        $stmt_count->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt_count->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    }
    if (!empty($branch)) {
        $stmt_count->bindValue(':branch', "%$branch%", PDO::PARAM_STR);
    }
    $stmt_count->execute();
    $total_rows = $stmt_count->fetchColumn();

    // Calculate total pages
    $total_pages = ceil($total_rows / $limit);

} catch (PDOException $e) {
    // Log the error or display a detailed error message
    error_log('PDOException: ' . $e->getMessage()); // Log the error
    echo '<div class="container"><p>Error fetching data. Please try again later.</p></div>';
    exit(); // Exit script on error
}
?>

<!-- HTML content for displaying the report -->
<div class="container">
    <h2>Breaks Report</h2>

    <!-- Filters -->
    <div class="row">
        <div class="col-md-3">
            <label for="fullname">Search Name</label>
            <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($fullname) ?>" placeholder="Search by name" class="form-control rounded-0">
        </div>
        <div class="col-md-3">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control rounded-0">
        </div>
        <div class="col-md-3">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control rounded-0">
        </div>
        <div class="col-md-3">
            <label for="branch">Branch</label>
            <input type="text" id="branch" name="branch" value="<?= htmlspecialchars($branch) ?>" placeholder="Search by branch" class="form-control rounded-0">
        </div>
    </div>
    <br>

    <?php if (!empty($breaks)): ?>
        <div class="table-responsive">
            <table class="table table-condensed table-custom">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Fullname</th>
                        <th>Date</th>
                        <th>Bio In</th>
                        <th>Bio Exceed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($breaks as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['user_id']) ?></td>
                            <td><?= htmlspecialchars($row['fullname']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['bio_in']) ?></td>
                            <td><?= htmlspecialchars($row['bio_exceed']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= ($page - 1) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&fullname=<?= urlencode($fullname) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>&branch=<?= urlencode($branch) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= ($page + 1) ?>&fullname=<?= urlencode($fullname) ?>&start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>&branch=<?= urlencode($branch) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- End Pagination -->

    <?php else: ?>
        <div class="container">
            <p>No breaks recorded.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Include your JS files here -->
<?php include 'include/footer.php'; ?>

<script>
$(function(){
    $('#filter').click(function(){
        var fullname = $('#fullname').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var branch = $('#branch').val();

        var url = "./breaks-report.php";
        url += "?fullname=" + fullname;
        url += "&start_date=" + start_date;
        url += "&end_date=" + end_date;
        url += "&branch=" + branch;
        
        location.href = url;
    });
});
</script>
