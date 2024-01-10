document.addEventListener('DOMContentLoaded', function () {
  const startBtn = document.getElementById('startBtn');
  const stopBtn = document.getElementById('stopBtn');

  // Set initial button colors
  startBtn.style.backgroundColor = '	#eeeeee';  // Green color
  stopBtn.style.backgroundColor = '	#eeeeee';   // Red color

  startBtn.addEventListener('click', function () {
    chrome.runtime.sendMessage({ action: 'startCapture' });
    // Change button colors
    startBtn.style.backgroundColor = '#8BC34A';  // Light Green color
    stopBtn.style.backgroundColor = '	#eeeeee';   // Red color
  });

  stopBtn.addEventListener('click', function () {
    chrome.runtime.sendMessage({ action: 'stopCapture' });
    // Change button colors
    startBtn.style.backgroundColor = '	#eeeeee';  // Green color
    stopBtn.style.backgroundColor = '#EF5350';   // Light Red color
  });
});

document.getElementById('startBtn').addEventListener('click', function() {
  chrome.runtime.sendMessage({ action: 'startCapture' });
});

document.getElementById('stopBtn').addEventListener('click', function() {
  chrome.runtime.sendMessage({ action: 'stopCapture' });
});



