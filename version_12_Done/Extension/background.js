///***Below here functions is when start button collect capture URL, when click 'stop' button it can send all the URL to python***/
// let isCapturing = false;
// let capturedData = [];

// chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
//   if (request.action === 'startCapture') {
//     isCapturing = true;
//     capturedData = [];
//     // Add listeners for webNavigation events
//     chrome.webNavigation.onCompleted.addListener(captureData);
//   } else if (request.action === 'stopCapture') {
//     isCapturing = false;
//     // Remove listeners
//     chrome.webNavigation.onCompleted.removeListener(captureData);
//     // Send captured data to PHP file (you need to implement this part)
//     sendCapturedData(capturedData);
//   }
// });


// //display each URL in console
// function captureData(details) {
//   if (isCapturing) {
//     capturedData.push(details.url);
//     console.log('Captured URL:', details.url);
//   }
// }


//   function sendCapturedData(data) {
//     console.log("run send function");
//     // Convert the array of URLs to a JSON string
//     const jsonData = JSON.stringify({ urls: data });
  
//     // Use fetch to send a POST request to your localhost Python file
//     fetch('http://localhost:8000/GetURL', {
//       method: 'POST',
//       body: jsonData,
//       headers: {
//         'Content-Type': 'application/json'
//       }
//     })
//     .then(response => {
//       if (!response.ok) {
//         throw new Error('Network response was not ok');
//       }
//       return response.json();
//     })
//     .then(responseData => {
//       console.log('Server response:', responseData);
//       // Check responseData for any specific success indicators
//       if (responseData.status === 'success') {
//         console.log('Data successfully processed on the server.');
//       } else {
//         console.error('Server response indicates an error:', responseData);
//       }
//     })
//     .catch(error => {
//       console.error('Error:', error);
//     });
//   }
  
  


/// *** Below here is ***/ 
let isCapturing = false;

chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
  if (request.action === 'startCapture') {
    isCapturing = true;
    // Add listeners for webNavigation events
    chrome.webNavigation.onCompleted.addListener(captureAndSend);
  } else if (request.action === 'stopCapture') {
    isCapturing = false;
    // Remove listeners
    chrome.webNavigation.onCompleted.removeListener(captureAndSend);
  }
});

function captureAndSend(details) {
  const url = details.url;
  
  // Send the captured URL immediately
  sendCapturedData([url]);
}

function sendCapturedData(data) {
  // Convert the array of URLs to a JSON string
  const jsonData = JSON.stringify({ urls: data });

  // Use fetch to send a POST request to your localhost Python file
  fetch('http://localhost:8000/GetURL3', {
    method: 'POST',
    body: jsonData,
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(responseData => {
    console.log('Server response:', responseData);
    // Check responseData for any specific success indicators
    if (responseData.status === 'success') {
      console.log('Data successfully processed on the server.');
    } else {
      console.error('Server response indicates an error:', responseData);
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}
