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
<br>
CREATE TABLE sign_up ( <br>
    Sign_up_details_email VARCHAR(60) COLLATE utf8mb4_general_ci NOT NULL PRIMARY KEY, <br>
    Sign_up_details_pass VARCHAR(60) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_IC VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_Name VARCHAR(40) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_PhoneNumber VARCHAR(12) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_address1 VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_address2 VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_city VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_State VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_postal VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Sign_up_details_firstAppointment DATE NOT NULL <br>
);
<br>
CREATE TABLE Pregnancy_report1 ( <br>
    report_Ic_Number VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL PRIMARY KEY, <br>
    report_month VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_first_name VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_last_name VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_patient_tel VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_patient_birthday VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_patient_email VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_patient_address1 VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_patient_address2 VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_first_city VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_state VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    report_postal VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL, <br>
    bloodPressure VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL, <br>
    weight1 VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL, <br>
    ultraSound VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL, <br>
    fetalHeartRate VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL, <br>
    maternalSymptoms VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL, <br>
    immunizations VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL, <br>
    doctorreport VARCHAR(1000) COLLATE utf8mb4_general_ci NOT NULL <br>
);
<br>
CREATE TABLE appointment ( <br>
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, <br>
    Appointment_date DATE NOT NULL, <br>
    Appointment_time VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Appointment_email VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Appointment_name VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL, <br>
    Appointment_room VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL <br>
);
<br>
CREATE TABLE messages ( <br>
    message_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, <br>
    sender_email VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL, <br>
    recipient_email VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL, <br>
    title VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL, <br>
    description TEXT COLLATE utf8mb4_general_ci DEFAULT NULL <br>
);
<br>
CREATE TABLE login_attempts ( <br>
    id INT AUTO_INCREMENT PRIMARY KEY, <br>
    email VARCHAR(255) NOT NULL, <br>
    ip_address VARCHAR(45) NOT NULL, <br>
    attempt_time DATETIME NOT NULL, <br>
    is_successful BOOLEAN DEFAULT FALSE <br>
);
<br>

## ENVIROMENT VARIABLE 
- Create a .env file in the root directory and add the following: <br>
ENCRYPTION_KEY="EbvH32B782dMeNzD3aivR2SsMt0OeWHf" <br>
ENCRYPTION_IV="kyHNAOuJpP0y8DMl"  <br>


# How to launch
- Ensure that the project is located within the XAMPP htdoc directory <br>
- Ensure that the Apache and MySQL service is started <br>
- Type `localhost/NameOfTheDirectoryWhereTheProjectLocatedInXAMPPhtdoc/login1` in the browser search bar and enter <br>
- The login page will be displayed <br>
