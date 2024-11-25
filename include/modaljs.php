<!-- Modal Template and JavaScript Combined -->
<form id="breakForm">
    <!-----------modal bio-------------->
    <div class="modal fade" id="biobreak" tabindex="-1" role="dialog" aria-labelledby="bioLabel" aria-hidden="true" data-keyboard="" data-backdrop="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bioLabel">Bio Break</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <div id="date"></div>
                        <div id="bio">05:00</div>
                    </center>
                    <center>
                        <div id="exceedingTime"></div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary end-break" data-modal-id="#biobreak">End Break</button>
                </div>
            </div>
        </div>
    </div>

<!-----------modal Short-------------->
    <div class="modal fade" id="shortbreak" tabindex="-1" role="dialog" aria-labelledby="shortLabel" aria-hidden="true" data-keyboard="" data-backdrop="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shortLabel">Short Break</h5>
                    <button type="button" class="close" data-dismiss="modal1" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <div id="date2"></div>
                        <div id="short">15:00</div>
                    </center>
                    <center>
                        <div id="exceedingTime1"></div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary end-break" data-modal-id="#shortbreak">End Break</button>
                </div>
            </div>
        </div>
    </div>

<!-----------modal 30 min Short-------------->
<div class="modal fade" id="shortbreak30" tabindex="-1" role="dialog" aria-labelledby="shortLabel" aria-hidden="true" data-keyboard="" data-backdrop="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shortLabel">30 min Short Break</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <div id="date5"></div>
                    <div id="short30">30:00</div>
                </center>
                <center>
                    <div id="exceedingTime4"></div>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">End Break</button>
            </div>
        </div>
    </div>
</div>
<!-----------modal 45 min Short-------------->
    <div class="modal fade" id="shortbreak45" tabindex="-1" role="dialog" aria-labelledby="shortLabel" aria-hidden="true" data-keyboard="" data-backdrop="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shortLabel">45 min Short Break</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <div id="date6"></div>
                    <div id="short45">45:00</div>
                </center>
                <center>
                    <div id="exceedingTime3"></div>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">End Break</button>
            </div>
        </div>
    </div>
</div>

    <!-----------modal meal-------------->
    <div class="modal fade" id="mealbreak" tabindex="-1" role="dialog" aria-labelledby="shortLabel" aria-hidden="true" data-keyboard="" data-backdrop="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mealLabel">Meal Break</h5>
                    <button type="button" class="close" data-dismiss="modal2" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <div id="date3"></div>
                        <div id="meal">60:00</div>
                    </center>
                    <center>
                        <div id="exceedingTime2"></div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary end-break" data-modal-id="#mealbreak">End Break</button>
                </div>
            </div>
        </div>
    </div>


</form>
<!----------------Bio Break js-------------------->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var currentDateElement = document.getElementById('date');
    var display = document.getElementById('bio');
    var exceedingTimeElement = document.getElementById('exceedingTime');
    var timerInterval, exceedingInterval;
    var startTimeKey = 'timerStartTime';
    var exceedingStartTimeKey = 'exceedingStartTime';

    // Function to update the current date and time
    function updateDate() {
        var currentDate = new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" });
        var options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour: 'numeric', 
            minute: 'numeric', 
            second: 'numeric', 
            hour12: true // Use 12-hour format
        };
        currentDateElement.textContent = new Date(currentDate).toLocaleDateString('en-US', options);
    }

    // Function to start the timer
    function startTimer(duration, display) {
        var startTime = Date.now();
        var endTime = startTime + duration * 1000; // End time in milliseconds

        function updateTimer() {
            var currentTime = Date.now();
            var remainingTime = Math.max(0, Math.floor((endTime - currentTime) / 1000)); // Calculate remaining time in seconds

            var minutes = Math.floor(remainingTime / 60);
            var seconds = remainingTime % 60;

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (remainingTime <= 0) { // Stop the timer when remaining time reaches 0
                clearInterval(timerInterval);
            }
        }

        // Call updateTimer initially to start the timer immediately
        updateTimer();

        // Update timer every second
        timerInterval = setInterval(updateTimer, 1000);
    }

    // Function to start the exceeding time
    function startExceedingTime(exceedingStartTime) {
        function updateExceedingTime() {
            var currentTime = Date.now();
            var exceedingTime = Math.floor((currentTime - exceedingStartTime) / 1000);

            var hours = Math.floor(exceedingTime / 3600);
            var minutes = Math.floor((exceedingTime % 3600) / 60);
            var seconds = exceedingTime % 60;
            exceedingTimeElement.textContent = "Exceeding Time: " + hours + "h " + minutes + "m " + seconds + "s";
        }

        updateExceedingTime();
        exceedingInterval = setInterval(updateExceedingTime, 1000);
    }

    // Call updateDate initially to set the current date and time
    updateDate();

    // Update the date and time every second
    setInterval(updateDate, 1000);

    var startTimerButton = document.getElementById('startTimerButton');
    if (startTimerButton) { // Check if element exists
        startTimerButton.addEventListener('click', function () {
            var fiveMinutes = 5 * 60;
            var storedStartTime = localStorage.getItem(startTimeKey);
            var remainingTime = fiveMinutes;

            if (storedStartTime) {
                var elapsed = Date.now() - parseInt(storedStartTime);
                remainingTime -= Math.floor(elapsed / 1000);
            }

            // Clear any existing intervals before starting new ones
            clearInterval(timerInterval);
            clearInterval(exceedingInterval);

            // Start the timer
            startTimer(remainingTime, display);
            localStorage.setItem(startTimeKey, Date.now());

            // Setup a delay before starting the exceeding time interval
            setTimeout(function () {
                var exceedingStartTime = Date.now();
                startExceedingTime(exceedingStartTime);
                localStorage.setItem(exceedingStartTimeKey, exceedingStartTime);
            }, remainingTime * 1000); // Delay according to remaining time
        });
    }

    // Check if there's an existing timer when the page loads
    var storedStartTime = localStorage.getItem(startTimeKey);
    if (storedStartTime) {
        var fiveMinutes = 5 * 60;
        var elapsed = Date.now() - parseInt(storedStartTime);
        var remainingTime = fiveMinutes - Math.floor(elapsed / 1000);

        if (remainingTime > 0) {
            startTimer(remainingTime, display);
        } else {
            // Start exceeding time immediately if the 5 minutes have passed
            var storedExceedingStartTime = localStorage.getItem(exceedingStartTimeKey) || storedStartTime;
            startExceedingTime(parseInt(storedExceedingStartTime));
        }
    }

    // End break logic
    document.querySelector('.end-break').addEventListener('click', function () {
        clearInterval(timerInterval);
        clearInterval(exceedingInterval);

        // Clear the stored start time when the break ends
        localStorage.removeItem(startTimeKey);
        localStorage.removeItem(exceedingStartTimeKey);

        // Gather data to send to the server
        var bioIn = display.textContent;
        var bioExceed = exceedingTimeElement.textContent;
        var date = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" })).toISOString().slice(0, 19).replace('T', ' '); // Format date as YYYY-MM-DD HH:MM:SS
        var userId = 1; // Replace with actual user ID
        var fullname = "<?php echo $user_name; ?>"; // Replace with actual user fullname

        // Send data to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "bio_save.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Break data saved successfully");
                console.log("Response:", xhr.responseText); // Debugging line
            }
        };
        var data = "user_id=" + userId + "&fullname=" + encodeURIComponent(fullname) + "&date=" + encodeURIComponent(date) + "&bio_in=" + encodeURIComponent(bioIn) + "&bio_exceed=" + encodeURIComponent(bioExceed);
        console.log("Sending data:", data); // Debugging line
        xhr.send(data);

        // Hide the modal
        $('#biobreak').modal('hide');

        // Reset timer and exceeding time
        display.textContent = "00:00";
        exceedingTimeElement.textContent = "Exceeding Time: 00h 00m 00s";
    });
});
</script>




<!---------------15 minute Short Break js--------------------->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var currentDateElement = document.getElementById('date2');

    // Function to update the current date
    function updateDate() {
        var currentDate = new Date();
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        currentDateElement.textContent = currentDate.toLocaleDateString('en-US', options);
    }

    // Function to start the timer
    function startTimer(duration, display) {
        var startTime;
        var storedStartTime = localStorage.getItem('startTime'); // Retrieve start time from localStorage
        if (storedStartTime) {
            startTime = parseInt(storedStartTime, 10); // Parse the stored start time
        } else {
            startTime = Date.now(); // Set start time if not stored
            localStorage.setItem('startTime', startTime); // Store start time in localStorage
        }

        var endTime = startTime + duration * 1000; // End time in milliseconds

        function updateTimer() {
            var currentTime = Date.now();
            var remainingTime = Math.max(0, Math.floor((endTime - currentTime) / 1000)); // Calculate remaining time in seconds

            var minutes = Math.floor(remainingTime / 60);
            var seconds = remainingTime % 60;

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            if (display) { // Check if display element exists
                display.textContent = minutes + ":" + seconds;
            }

            if (remainingTime <= 0) { // Stop the timer when remaining time reaches 0
                clearInterval(timerInterval);
            }
        }

        // Call updateTimer initially to start the timer immediately
        updateTimer();

        // Update timer every second
        var timerInterval = setInterval(updateTimer, 1000);
        return timerInterval; // Return the interval ID
    }

    // Call updateDate initially to set the current date
    updateDate();

    // Update the date every second
    setInterval(updateDate, 1000);

    var startTimerButton1 = document.querySelector('#startTimerButton1');
    if (startTimerButton1) { // Check if element exists
        startTimerButton1.addEventListener('click', function () {
            var fifteenMinutes = 15 * 60,
                display = document.querySelector('#short'),
                timerInterval = startTimer(fifteenMinutes, display),
                exceedingStartTime,
                exceedingInterval;

            // Setup a delay before starting the exceeding time interval
            setTimeout(function () {
                exceedingStartTime = Date.now();

                // Update exceeding time every second
                exceedingInterval = setInterval(function () {
                    var currentTime = Date.now();
                    var exceedingTime = Math.floor((currentTime - exceedingStartTime) / 1000);

                    var hours = Math.floor(exceedingTime / 3600);
                    var minutes = Math.floor((exceedingTime % 3600) / 60);
                    var seconds = exceedingTime % 60;
                    document.getElementById('exceedingTime1').textContent = "Exceeding Time: " + hours + "h " + minutes + "m " + seconds + "s";
                }, 1000);
            }, fifteenMinutes * 1000); // Delay of 15 minutes before starting exceeding time

            // Close the modal and clear the timer interval when 'Save changes' button is clicked
            document.querySelector('#shortbreak .btn-primary').addEventListener('click', function () {
                clearInterval(timerInterval);
                clearInterval(exceedingInterval);
                localStorage.removeItem('startTime'); // Remove stored start time
                $('#shortbreak').modal('hide');
                location.reload(); // Reload the page
            });
        });
    } else {
        console.error("startTimerButton1 not found");
    }
});
</script>



<!---------------30 Short Break js--------------------->
<script type="text/javascript">
   document.addEventListener('DOMContentLoaded', function () {
    var currentDateElement = document.getElementById('date5');

    // Function to update the current date
    function updateDate() {
        var currentDate = new Date();
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        currentDateElement.textContent = currentDate.toLocaleDateString('en-US', options);
    }

    // Function to start the timer
    function startTimer(duration, display) {
        var startTime = Date.now();
        var endTime = startTime + duration * 1000; // End time in milliseconds

        function updateTimer() {
            var currentTime = Date.now();
            var remainingTime = Math.max(0, Math.floor((endTime - currentTime) / 1000)); // Calculate remaining time in seconds

            var minutes = Math.floor(remainingTime / 60);
            var seconds = remainingTime % 60;

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            if (display) { // Check if display element exists
                display.textContent = minutes + ":" + seconds;
            }

            if (remainingTime <= 0) { // Stop the timer when remaining time reaches 0
                clearInterval(timerInterval);
            }
        }

        // Call updateTimer initially to start the timer immediately
        updateTimer();

        // Update timer every second
        var timerInterval = setInterval(updateTimer, 1000);
        return timerInterval; // Return the interval ID
    }

    // Call updateDate initially to set the current date
    updateDate();

    // Update the date every second
    setInterval(updateDate, 1000);

    var startTimerButton3 = document.querySelector('#startTimerButton3');
    if (startTimerButton3) { // Check if element exists
        startTimerButton3.addEventListener('click', function () {
            var thirtyMinutes = 30 * 60,
                display = document.querySelector('#short30'),
                timerInterval = startTimer(thirtyMinutes, display),
                exceedingStartTime,
                exceedingInterval; // Define exceedingInterval outside of setTimeout

            // Setup a delay before starting the exceeding time interval
            setTimeout(function () {
                exceedingStartTime = Date.now();

                // Update exceeding time every second
                exceedingInterval = setInterval(function () {
                    var currentTime = Date.now();
                    var exceedingTime = Math.floor((currentTime - exceedingStartTime) / 1000);

                    var hours = Math.floor(exceedingTime / 3600);
                    var minutes = Math.floor((exceedingTime % 3600) / 60);
                    var seconds = exceedingTime % 60;
                    document.getElementById('exceedingTime4').textContent = "Exceeding Time: " + hours + "h " + minutes + "m " + seconds + "s";
                }, 1000);
            }, thirtyMinutes * 1000); // Delay of 30 minutes before starting exceeding time

            // Close the modal and clear the timer interval when 'End Break' button is clicked
            document.querySelector('#shortbreak30 .btn-primary').addEventListener('click', function () {
                clearInterval(timerInterval);
                clearInterval(exceedingInterval);
                $('#shortbreak30').modal('hide');

                // Get necessary data
                var user_id = 1; // Replace with actual user ID
                var fullname = "John Doe"; // Replace with actual full name
                var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
                var thirty_in = display.textContent;
                var exceedingTime = document.getElementById('exceedingTime4').textContent;

                // Send data to PHP file via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "thirty_save.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send("user_id=" + user_id + "&fullname=" + fullname + "&date=" + date + "&thirty_in=" + thirty_in + "&thirty_exceed=" + exceedingTime);
            });
        });
    } else {
        console.error("startTimerButton3 not found");
    }
}); 

</script>


<!---------------45 Short Break js--------------------->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var currentDateElement = document.getElementById('date6');

        // Function to update the current date
        function updateDate() {
            var currentDate = new Date();
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            currentDateElement.textContent = currentDate.toLocaleDateString('en-US', options);
        }

        // Function to start the timer
        function startTimer(duration, display) {
            var startTime = Date.now();
            var endTime = startTime + duration * 1000; // End time in milliseconds

            function updateTimer() {
                var currentTime = Date.now();
                var remainingTime = Math.max(0, Math.floor((endTime - currentTime) / 1000)); // Calculate remaining time in seconds

                var minutes = Math.floor(remainingTime / 60);
                var seconds = remainingTime % 60;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                if (display) { // Check if display element exists
                    display.textContent = minutes + ":" + seconds;
                }

                if (remainingTime <= 0) { // Stop the timer when remaining time reaches 0
                    clearInterval(timerInterval);
                }
            }

            // Call updateTimer initially to start the timer immediately
            updateTimer();

            // Update timer every second
            var timerInterval = setInterval(updateTimer, 1000);
            return timerInterval; // Return the interval ID
        }

        // Call updateDate initially to set the current date
        updateDate();

        // Update the date every second
        setInterval(updateDate, 1000);

        var startTimerButton4 = document.querySelector('#startTimerButton4');
        if (startTimerButton4) { // Check if element exists
            startTimerButton4.addEventListener('click', function () {
                var fortyFiveMinutes = 45 * 60,
                    display = document.querySelector('#short45'),
                    timerInterval = startTimer(fortyFiveMinutes, display),
                    exceedingStartTime,
                    exceedingInterval; // Define exceedingInterval outside of setTimeout

                // Setup a delay before starting the exceeding time interval
                setTimeout(function () {
                    exceedingStartTime = Date.now();

                    // Update exceeding time every second
                    exceedingInterval = setInterval(function () {
                        var currentTime = Date.now();
                        var exceedingTime = Math.floor((currentTime - exceedingStartTime) / 1000);

                        var hours = Math.floor(exceedingTime / 3600);
                        var minutes = Math.floor((exceedingTime % 3600) / 60);
                        var seconds = exceedingTime % 60;
                        document.getElementById('exceedingTime3').textContent = "Exceeding Time: " + hours + "h " + minutes + "m " + seconds + "s";
                    }, 1000);
                }, fortyFiveMinutes * 1000); // Delay of 45 minutes before starting exceeding time

                // Close the modal and clear the timer interval when 'End Break' button is clicked
                document.querySelector('#shortbreak45 .btn-primary').addEventListener('click', function () {
                    clearInterval(timerInterval);
                    clearInterval(exceedingInterval);
                    $('#shortbreak45').modal('hide');
                });
            });
        } else {
            console.error("startTimerButton4 not found");
        }
    });
</script>



<!---------------Meal Break js--------------------->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentDateElement = document.getElementById('date3');

        // Function to update the current date
        function updateDate() {
            var currentDate = new Date();
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            currentDateElement.textContent = currentDate.toLocaleDateString('en-US', options);
        }

        // Function to start the timer
        function startTimer(duration, display) {
            var startTime = Date.now();
            var endTime = startTime + duration * 1000; // End time in milliseconds

            function updateTimer() {
                var currentTime = Date.now();
                var remainingTime = Math.max(0, Math.floor((endTime - currentTime) / 1000)); // Calculate remaining time in seconds

                var minutes = Math.floor(remainingTime / 60);
                var seconds = remainingTime % 60;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                if (display) { // Check if display element exists
                    display.textContent = minutes + ":" + seconds;
                }

                if (remainingTime <= 0) { // Stop the timer when remaining time reaches 0
                    clearInterval(timerInterval);
                }
            }

            // Call updateTimer initially to start the timer immediately
            updateTimer();

            // Update timer every second
            var timerInterval = setInterval(updateTimer, 1000);
            return timerInterval; // Return the interval ID
        }

        // Call updateDate initially to set the current date
        updateDate();

        // Update the date every second
        setInterval(updateDate, 1000);

        var startTimerButton2 = document.querySelector('#startTimerButton2');
        if (startTimerButton2) { // Check if element exists
            startTimerButton2.addEventListener('click', function () {
                var sixtyMinutes = 60 * 60, // 60 minutes in seconds
                    display = document.querySelector('#meal'),
                    timerInterval = startTimer(sixtyMinutes, display),
                    exceedingStartTime,
                    exceedingInterval; // Define exceedingInterval

                // Setup a delay before starting the exceeding time interval
                setTimeout(function () {
                    exceedingStartTime = Date.now();

                    // Update exceeding time every second
                    exceedingInterval = setInterval(function () {
                        var currentTime = Date.now();
                        var exceedingTime = Math.floor((currentTime - exceedingStartTime) / 1000);

                        var hours = Math.floor(exceedingTime / 3600);
                        var minutes = Math.floor((exceedingTime % 3600) / 60);
                        var seconds = exceedingTime % 60;
                        document.getElementById('exceedingTime2').textContent = "Exceeding Time: " + hours + "h " + minutes + "m " + seconds + "s";
                    }, 1000);
                }, sixtyMinutes * 1000); // Delay of 60 minutes before starting exceeding time

                // Close the modal and clear the timer interval when 'Save changes' button is clicked
                document.querySelector('#mealbreak .btn-primary').addEventListener('click', function () {
                    clearInterval(timerInterval);
                    clearInterval(exceedingInterval);
                    $('#mealbreak').modal('hide');
                });
            });
        } else {
            console.error("startTimerButton2 not found");
        }
    });
</script>


