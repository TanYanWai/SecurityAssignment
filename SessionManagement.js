// Set the timeout duration (in milliseconds)
let inactivityTimeout = 1800000; // 10 seconds (10000) (1800000)

// Variable to hold the timeout ID
let timeoutId;

// Function to reset the timer
function resetInactivityTimer() {
    // Clear any existing timeout
    clearTimeout(timeoutId);

    // Set a new timeout
    timeoutId = setTimeout(redirectToLogin, inactivityTimeout);
}

// Function to redirect to the login page
function redirectToLogin() {
    window.location.href = 'login1.html'; // Replace with your login page URL
}

// Event listeners for user activity (reset timer on interaction)
window.onload = resetInactivityTimer;
document.onmousemove = resetInactivityTimer;
document.onkeydown = resetInactivityTimer;
document.onclick = resetInactivityTimer;


