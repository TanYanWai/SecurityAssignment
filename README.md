# How to install this project and run

## Prerequisites:
### Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/

Launch XAMPP after installation

Start Apache and MySQL services from XAMPP Control Panel


## Project Setup
Clone the project files to XAMPP's htdocs folder:
- Windows: `C:\xampp\htdocs\your_project_folder`
- Mac: `/Applications/XAMPP/htdocs/your_project_folder`
- Linux: `/opt/lampp/htdocs/your_project_folder`



## 3. Database Setup
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named "assignment"
3. Import the SQL table structure:

CREATE TABLE sign_up (
    Sign_up_details_email VARCHAR(60) COLLATE utf8mb4_general_ci NOT NULL PRIMARY KEY,
    Sign_up_details_pass VARCHAR(60) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_IC VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_Name VARCHAR(40) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_PhoneNumber VARCHAR(12) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_address1 VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_address2 VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_city VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_State VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_postal VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL,
    Sign_up_details_firstAppointment DATE NOT NULL
);
CREATE TABLE Pregnancy_report1 (
    report_Ic_Number VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL PRIMARY KEY,
    report_month VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    report_first_name VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
    report_last_name VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
    report_patient_tel VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    report_patient_birthday VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    report_patient_email VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    report_patient_address1 VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    report_patient_address2 VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    report_first_city VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    report_state VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    report_postal VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL,
    bloodPressure VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL,
    weight1 VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL,
    ultraSound VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL,
    fetalHeartRate VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL,
    maternalSymptoms VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
    immunizations VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
    doctorreport VARCHAR(1000) COLLATE utf8mb4_general_ci NOT NULL
);
CREATE TABLE appointment (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Appointment_date DATE NOT NULL,
    Appointment_time VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
    Appointment_email VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    Appointment_name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    Appointment_room VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL
);
CREATE TABLE messages (
    message_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sender_email VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    recipient_email VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    title VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    description TEXT COLLATE utf8mb4_general_ci DEFAULT NULL
);

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time DATETIME NOT NULL,
    is_successful BOOLEAN DEFAULT FALSE
);


## ENVIROMENT VARIABLE 
Create a .env file in the root directory and add the following:
ENCRYPTION_KEY="EbvH32B782dMeNzD3aivR2SsMt0OeWHf"
ENCRYPTION_IV="kyHNAOuJpP0y8DMl" 


# How to launch
Ensure that the project is located within the XAMPP htdoc directory
Ensure that the Apache and MySQL service is started
Type "localhost/<NameOfTheDirectoryWhereTheProjectLocatedInXAMPPhtdoc>/login1" in the browser search bar and enter
The login page will be displayed
