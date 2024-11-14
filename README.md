SQL Database Initialization

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time DATETIME NOT NULL,
    is_successful BOOLEAN DEFAULT FALSE
);


ENVIROMENT VARIABLE 
Create a .env file in the root directory and add the following:
ENCRYPTION_KEY="EbvH32B782dMeNzD3aivR2SsMt0OeWHf"
ENCRYPTION_IV="kyHNAOuJpP0y8DMl" 