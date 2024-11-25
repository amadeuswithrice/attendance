const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');

const app = express();

// MySQL connection
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'etms_db'
});

connection.connect(err => {
    if (err) {
        console.error('Error connecting to MySQL:', err);
        return;
    }
    console.log('Connected to MySQL database');
});

// Middleware
app.use(bodyParser.json());

// Route to save recording
app.post('/save_recording', (req, res) => {
    const { fullname, r_screen, filename } = req.body;

    const query = `INSERT INTO tbl_screencast (fullname, r_screen, filename) VALUES (?, ?, ?)`;
    connection.query(query, [fullname, r_screen, filename], (err, result) => {
        if (err) {
            console.error('Error saving recording to MySQL:', err);
            res.status(500).json({ error: 'An error occurred while saving recording.' });
            return;
        }
        console.log('Recording saved successfully to MySQL');
        res.status(200).json({ message: 'Recording saved successfully.' });
    });
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
