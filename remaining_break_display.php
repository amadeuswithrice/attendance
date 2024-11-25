<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remaining Break Time</title>
</head>
<body>
    <div id="remaining-time"></div>

    <script>
        // Function to update remaining break time dynamically
        function updateRemainingTime() {
            // Fetch the remaining break time from the server using AJAX
            fetch('remaining_break_time.php')
                .then(response => response.text())
                .then(remainingTime => {
                    // Display the remaining break time on the webpage
                    document.getElementById('remaining-time').innerText = 'Remaining Break Time: ' + remainingTime + ' minutes';
                });
        }

        // Update the remaining break time initially when the page loads
        updateRemainingTime();

        // Update the remaining break time every minute
        setInterval(updateRemainingTime, 60000);
    </script>
</body>

</html>
