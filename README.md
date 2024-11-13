SQL Database Initialization

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time DATETIME NOT NULL,
    is_successful BOOLEAN DEFAULT FALSE
);