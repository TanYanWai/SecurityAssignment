const mysql = require('mysql');

const connection = mysql.createConnection({
  host: 'localhost', // Replace with your MySQL server host
  user: 'root', // Replace with your MySQL username
  password: 'password', // Replace with your MySQL password
  database: 'your_database' // Replace with your MySQL database name
});

connection.connect((error) => {
  if (error) {
    console.error('Error connecting to the database:', error);
  } else {
    console.log('Connected to the database');
    // Start executing queries or perform other database operations
  }
});

connection.query('SELECT * FROM your_table', (error, results) => {
  if (error) {
    console.error('Error executing query:', error);
  } else {
    console.log('Query results:', results);
    // Process the query results
  }
});