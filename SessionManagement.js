// Set the timeout duration (in milliseconds)
let inactivityTimeout = 1800000; // 10 seconds (10000) (1800000)

// Variable to hold the timeout ID
let timeoutId;

// Function to reset the timer
function resetInactivityTimer() {
    // Clear any existing timeout
    clearTimeout(timeoutId);

    // Set a new timeout
    timeoutId = setTimeout(redirectToLogout, inactivityTimeout);
}

// Function to redirect to logout script (destroys session)
function redirectToLogout() {
    window.location.href = 'logout.php'; // Redirect to logout.php to destroy the session
}

// Event listeners for user activity (reset timer on interaction)
window.onload = resetInactivityTimer;
document.onmousemove = resetInactivityTimer;
document.onkeydown = resetInactivityTimer;
document.onclick = resetInactivityTimer;


