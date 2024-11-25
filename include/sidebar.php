<?php


if (!isset($_SESSION['user_role'])) {
    header('Location: index.php');
    exit();
}

$user_role = $_SESSION['user_role'];
$page_name = isset($page_name) ? $page_name : '';
?>

<nav class="navbar navbar-inverse sidebar navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="" class="navbar-toggle" data-toggle="" data-target="">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="task-info.php">
                <span style="color: #D5F4FF; font-weight: bold;">
                    <img src="include/img/logo1.png" alt="Description of image" class="custom-image" />
                </span>
            </a>
        </div>

        <div class="" id="bs-sidebar-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-nav-custom">
                <li <?= ($page_name == "Task_Info") ? 'class="active"' : ''; ?>>
                    <a href="task-info.php">Task Management
                        <span class="pull-right hidden-xs showopacity glyphicon glyphicon-tasks" style="font-size:16px; color:#D5F4FF;"></span>
                    </a>
                </li>
                <li <?= ($page_name == "Attendance") ? 'class="active"' : ''; ?>>
                    <a href="attendance-info.php">Attendance
                        <span class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar" style="font-size:16px; color:#D5F4FF;"></span>
                    </a>
                </li>
                <?php if ($user_role == 1): ?>
                    <li <?= ($page_name == "Admin") ? 'class="active"' : ''; ?>>
                        <a href="manage-admin.php">Administration
                            <span class="pull-right hidden-xs showopacity glyphicon glyphicon-user" style="font-size:16px; color:#D5F4FF;"></span>
                        </a>
                    </li>
                    <li <?= ($page_name == "Daily-Task-Report") ? 'class="active"' : ''; ?>>
                        <a href="daily-task-report.php">Task Report
                            <span class="pull-right hidden-xs showopacity glyphicon glyphicon-file" style="font-size:16px; color:#D5F4FF;"></span>
                        </a>
                    </li>
                    <li <?= ($page_name == "Daily-Attendance-Report") ? 'class="active"' : ''; ?>>
                        <a href="daily-attendance-report.php">Attendance Report
                            <span class="pull-right hidden-xs showopacity glyphicon glyphicon-file" style="font-size:16px; color:#D5F4FF;"></span>
                        </a>
                    </li>
                    <li <?= ($page_name == "daily-breaks-report") ? 'class="active"' : ''; ?>>
                        <a href="daily-breaks-report.php">Breaks Report
                            <span class="pull-right hidden-xs showopacity glyphicon glyphicon-file" style="font-size:16px; color:#D5F4FF;"></span>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="?logout=logout">Logout
                        <span class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out" style="font-size:16px; color:#D5F4FF;"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
