window.addEventListener('DOMContentLoaded', function () {
  var servingNumbers = [0, 0, 0, 0]; // Array to store the serving numbers

  // Serving time in seconds for each room
  var servingTimes = [5, 10, 15, 20];

  for (var i = 0; i < servingNumbers.length; i++) {
    startServing(i);
  }

  function startServing(roomIndex) {
    setInterval(function () {
      servingNumbers[roomIndex]++; // Increment the serving number
      document.getElementById('serving-number-' + (roomIndex + 1)).textContent = servingNumbers[roomIndex];
    }, servingTimes[roomIndex] * 1000); // Update the serving numbers based on serving times
  }
  function updateTime() {
    var now = new Date();
    var options = {
      timeZone: 'Asia/Kuala_Lumpur',
      hour12: false,
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric'
    };
    var formattedTime = now.toLocaleString('en-MY', options);
    document.getElementById('clock-time').textContent = formattedTime;
  }

  updateTime();
  setInterval(updateTime, 1000);
});
