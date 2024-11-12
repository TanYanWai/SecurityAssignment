window.addEventListener('DOMContentLoaded', function() {
    var servingNumbers = [0, 0, 0, 0]; // Array to store the serving numbers
    var servingTimes = [5, 10, 15, 20]; // Serving time in seconds for each room
  
    // Function to increment the serving number and update the display for a specific room
    function incrementServingNumber(roomIndex) {
      servingNumbers[roomIndex]++; // Increment the serving number
      document.getElementById('serving-number-' + (roomIndex + 1)).textContent = servingNumbers[roomIndex];
  
      // Send the updated serving number to the server to update the database
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'LiveQueue.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            console.log('Serving number updated successfully.');
          } else {
            console.log('Failed to update the serving number.');
          }
        }
      };
      xhr.send('room=' + (roomIndex + 1) + '&servingNumber=' + servingNumbers[roomIndex]);
    }
  
    // Function to handle the "Next" button click event for a specific room
    function onNextButtonClick(roomIndex) {
      incrementServingNumber(roomIndex);
    }
  
    // Bind the onNextButtonClick function to the "Next" buttons click events
    var nextButtons = document.querySelectorAll('.next-button button');
    for (var i = 0; i < nextButtons.length; i++) {
      nextButtons[i].addEventListener('click', onNextButtonClick.bind(null, i));
    }
  });