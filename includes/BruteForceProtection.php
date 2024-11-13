<?php
class BruteForceProtection {
    private $conn;
    private $maxAttempts = 5;        // Maximum failed attempts
    private $lockoutDuration = 900;   // Changed to 15 minutes 
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getMaxAttempts() {
        return $this->maxAttempts;
    }
    
    public function recordLoginAttempt($email, $isSuccessful = false) {
        $ip = $this->getClientIP();
        $stmt = $this->conn->prepare("INSERT INTO login_attempts (email, ip_address, attempt_time, is_successful) VALUES (?, ?, NOW(), ?)");
        $stmt->bind_param("ssi", $email, $ip, $isSuccessful);
        $stmt->execute();
    }
    
    public function isIPBlocked() {
        
        // If lockout period has passed, check recent failed attempts
        $ip = $this->getClientIP();
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as attempt_count 
            FROM login_attempts 
            WHERE ip_address = ? 
            AND is_successful = 0 
            AND attempt_time > DATE_SUB(NOW(), INTERVAL ? SECOND)
        ");
        
        $stmt->bind_param("si", $ip, $this->lockoutDuration);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['attempt_count'] >= $this->maxAttempts;
    }
    
    public function getRemainingLockoutTime() {
        $ip = $this->getClientIP();
        $stmt = $this->conn->prepare("
            SELECT MAX(attempt_time) as last_attempt 
            FROM login_attempts 
            WHERE ip_address = ? 
            AND is_successful = 0
        ");
        
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['last_attempt']) {
            $lastAttempt = strtotime($row['last_attempt']);
            $currentTime = time();
            $timePassed = $currentTime - $lastAttempt;
            $remainingTime = $this->lockoutDuration - $timePassed;
            
            
            return max(0, $remainingTime);
        }
        return 0;
    }
    
    public function getFailedAttempts($email) {
        $ip = $this->getClientIP();
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as failed_count 
            FROM login_attempts 
            WHERE ip_address = ? 
            AND email = ?
            AND is_successful = 0 
            AND attempt_time > DATE_SUB(NOW(), INTERVAL ? SECOND)
        ");
        
        $stmt->bind_param("ssi", $ip, $email, $this->lockoutDuration);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return (int)$row['failed_count'];
    }
    
    private function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return filter_var($ip, FILTER_VALIDATE_IP);
    }
}
?>