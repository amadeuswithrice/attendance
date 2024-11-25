<button id="startTimerButton" type="button" class="btn btn-primary" data-toggle="modal" data-target="#biobreak">
   5min Bio Break
</button>

<button id="startTimerButton1" type="button" class="btn btn-primary" data-toggle="modal" data-target="#shortbreak">
    15min Short Break
</button>

<button id="startTimerButton2" type="button" class="btn btn-primary" data-toggle="modal" data-target="#mealbreak">
   60min Meal Break
</button>

<!-----------modal bio-------------->
<div class="modal fade" id="biobreak" tabindex="-1" role="dialog" aria-labelledby="bioLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bioLabel">Bio Break</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   
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
                
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-----------modal Short-------------->
<div class="modal fade" id="shortbreak" tabindex="-1" role="dialog" aria-labelledby="shortLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-----------modal meal-------------->
<div class="modal fade" id="mealbreak" tabindex="-1" role="dialog" aria-labelledby="shortLabel" aria-hidden="true">
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
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!----------------Bio Break js-------------------->
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
    var currentDateElement = document.getElementById('date');

    // Function to update the current date
    function updateDate() {
        var currentDate = new Date();
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        currentDateElement.textContent = currentDate.toLocaleDateString('en-US', options);
    }

    // Function to start the timer
    function startTimer(duration, display) {
        var bio = duration,
            minutes,
            seconds;

        function updateTimer() {
            minutes = parseInt(bio / 60, 10);
            seconds = parseInt(bio % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            if (display) { // Check if display element exists
                display.textContent = minutes + ":" + seconds;
            }

            if (bio <= 0) { // Stop the timer when bio reaches 0
                clearInterval(timerInterval);
            }

            if (bio < 0) { // Ensure the timer doesn't display negative values
                bio = 0;
            }

            bio--; // Decrement bio every second
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

    var startTimerButton = document.getElementById('startTimerButton');
    if (startTimerButton) { // Check if element exists
        startTimerButton.addEventListener('click', function () {
            var fiveMinutes = 5 * 60,
                display = document.querySelector('#bio'),
                timerInterval = startTimer(fiveMinutes, display),
                exceedingTime = 0,
                exceedingInterval; // Define exceedingInterval outside of setTimeout

            // Setup a delay before starting the exceeding time interval
            setTimeout(function () {
                // Update exceeding time every second
                exceedingInterval = setInterval(function () {
                    exceedingTime++;
                    var hours = Math.floor(exceedingTime / 3600);
                    var minutes = Math.floor((exceedingTime % 3600) / 60);
                    var seconds = exceedingTime % 60;
                    document.getElementById('exceedingTime').textContent = "Exceeding Time: " + hours + "h " + minutes + "m " + seconds + "s";
                }, 1000);
            }, 300000); // Delay of 5 minutes (300,000 milliseconds) before starting exceeding time

            // Close the modal and clear both intervals when 'Save changes' button is clicked
            document.querySelector('#biobreak .btn-primary').addEventListener('click', function () {
                clearInterval(timerInterval);
                clearInterval(exceedingInterval);
            });
        });
    } else {
        console.error("startTimerButton not found");
    }
});

</script>


<!---------------Short Break js--------------------->
<script type="text/javascript">
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
        var short = duration,
            minutes,
            seconds;

        function updateTimer() {
            minutes = parseInt(short / 60, 10);
            seconds = parseInt(short % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            if (display) { // Check if display element exists
                display.textContent = minutes + ":" + seconds;
            }

            if (short <= 0) { // Stop the timer when short reaches 0
                clearInterval(timerInterval);
            }

            if (short < 0) { // Ensure the timer doesn't display negative values
                short = 0;
            }

            short--; // Decrement short every second
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
                exceedingTime = 0,
                exceedingInterval; // Define exceedingInterval outside of setTimeout

            // Setup a delay before starting the exceeding time interval
            setTimeout(function () {
                // Update exceeding time every second
                exceedingInterval = setInterval(function () {
                    exceedingTime++;
                    var hours = Math.floor(exceedingTime / 3600);
                    var minutes = Math.floor((exceedingTime % 3600) / 60);
                    var seconds = exceedingTime % 60;
                    document.getElementById('exceedingTime1').textContent = "Exceeding Time: " + hours + "h " + minutes + "m " + seconds + "s";
                }, 1000);
            }, 15 * 60 * 1000); // Delay of 15 minutes before starting exceeding time

            // Close the modal and clear the timer interval when 'Save changes' button is clicked
            document.querySelector('#shortbreak .btn-primary').addEventListener('click', function () {
                clearInterval(timerInterval);
                clearInterval(exceedingInterval);
                $('#shortbreak').modal('hide');
            });
        });
    } else {
        console.error("startTimerButton not found");
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
        var timerInterval;

        function updateTimer() {
            var minutes = parseInt(duration / 60, 10);
            var seconds = parseInt(duration % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            if (display) { // Check if display element exists
                display.textContent = minutes + ":" + seconds;
            }

            if (duration <= 0) { // Stop the timer when duration reaches 0
                clearInterval(timerInterval);
            }

            duration--; // Decrement duration every second
        }

        // Call updateTimer initially to start the timer immediately
        updateTimer();

        // Update timer every second
        timerInterval = setInterval(updateTimer, 1000);
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
                exceedingTime = 0,
                exceedingInterval; // Define exceedingInterval

            // Setup a delay before starting the exceeding time interval
            setTimeout(function () {
                // Update exceeding time every second
                exceedingInterval = setInterval(function () {
                    exceedingTime++;
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



