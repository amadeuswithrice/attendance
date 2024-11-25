<?php
require 'authentication.php'; // admin authentication check 

// auth check
if(isset($_SESSION['admin_id'])){
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['admin_name'];
  $security_key = $_SESSION['security_key'];
  if ($user_id != NULL && $security_key != NULL) {
    header('Location: attendance-info.php');
  }
}

if(isset($_POST['login_btn'])){
 $info = $obj_admin->admin_login_check($_POST);
}

$page_name="Login";
include("include/login_header.php");
?>

<style>
body{
    background-color: white;
    margin:0;
    padding:0;
}

.main-content{
    display:table;
    height:100vh;
    width:100%;
    text-align: center;
    background-color: transparent;
}

.login-box{
    display:table-cell;
    vertical-align: middle;
    max-width: 400px;

}

.login-window{
    font-family:'Lato', sans-serif;
    display:block;
    position:relative;
    margin: 0 auto;
    background-color:red;
    max-width:400px;
    width:calc(90vw - 60px);
    text-align:left;
    padding:20px;
    border-radius:12px;
    -webkit-border-radius:12px;
    -webkit-box-shadow: 0 20px 40px 0 red;
	box-shadow: 0 20px 40px 0 red;
}


form label{
    font-family:'Oswald', sans-serif;

    
}
.login-title{
    text-transform: uppercase;
    text-align:center;
    font-weight:700;
    font-size:24px;
    letter-spacing:0.5em;
    font-family:'Lato', sans-serif;
	color: white; /* Change this to the desired color */
}

.mui-btn{
    color:white !important;
    background-color:black;
    border-radius:6px !important;
    -webkit-border-radius:6px !important;
    -webkit-box-shadow: 0 0 10px 0 #000000;
	box-shadow: 0 0 10px 0 #000000;
}

 /* This will target the input field with the id 'username' */
 	#username::placeholder {
        color: black;
    }

    /* This will target the input field with the id 'password' */
    #password::placeholder {
        color: black;
    }
</style>

<?php if(isset($info)): ?>
<h5 class="alert alert-danger"><?php echo htmlspecialchars($info); ?></h5>
<?php endif; ?>

<div class="main-content">
    <div class="login-box">
        <div class="login-window">
		<center><div style="background-color: white; border-radius: 1%; padding: 1px;">
<img src="include/img/logo1.png" alt="Company Logo" height="80">
</div></center> <br>
            <form class="mui-form" method="POST">
                <div class="login-title">
                    
                    Login
                </div>
				<br>
                <div class="form-group" >
                    <input type="text" id="username"  class="form-control rounded-0" placeholder="Username" name="username" style="background-color: #ffffff;" required>
                </div>
                <div class="form-group" ng-class="{'has-error': loginForm.password.$invalid && loginForm.password.$dirty, 'has-success': loginForm.password.$valid}">
                    <input type="password" id="password" class="form-control rounded-0" placeholder="Password" name="admin_password" required/>
                </div>
                <button type="submit" name="login_btn" class="mui-btn">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php

include("include/footer.php");

?>