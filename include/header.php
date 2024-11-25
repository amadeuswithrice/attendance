<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee time Management</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/bootstrap.theme.min.css">
  <link rel="stylesheet" href="./assets/css/custom.css">
 
  <script src="./assets/js/jquery.min.js"></script>
  <script src="./assets/js/bootstrap.min.js"></script>
  <script src="./assets/js/custom.js"></script>
 
</head>
<body>
  
</head>
<style>
/* Resetting default margin and padding */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Navbar styles */
.navbar {
  overflow: hidden; /* To contain the floated elements */
}

/* Navbar buttons */
.navbar a {
  display: inline-block; /* Make them inline-block elements */
  background-color: #333; /* Dark background color */
  color: white; /* Text color */
  text-align: center; /* Center text */
  padding: 10px 20px; /* Padding for each button */
  text-decoration: none; /* Remove underline */
  border: none; /* Remove border */
  cursor: pointer; /* Add pointer cursor */
  margin: 5px; /* Add margin between buttons */
}

/* Change color on hover */
.navbar a:hover {
  background-color: #555; /* Darker background color */
}

  .round-button {
    border-radius: 25px; /* Adjust this value as needed to get the desired oval shape */
    padding: 10px 20px;  /* Adjust padding to increase the size of the button */
    background-color: #007bff; /* Primary color (blue) */
    color: black; /* Text color */
    border: none; /* Optional: Remove border */
}

.round-button:hover {
    background-color: #0056b3; /* Darker blue for hover effect */
}

.custom-image {
            width: 100px; /* Specify the desired width */
            height: auto; /* Adjust height to maintain aspect ratio */
        }
</style>


<body>


<div class="row">
<div class="gap"></div>

  <div class="col-md-12">

    <div class="well">
      <div class="row">
        <div class="col-md-12 text-center">
          <marquee><span tyle="color: green;""> Hello <strong><?php echo $user_name; ?></strong>. A Friendly Reminder To You: <strong>Do Not Forget to Refresh the browser before clicking the breaks</strong></span></marquee>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="main">