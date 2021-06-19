'use strict' 
 
 // Get a list of vehicles in inventory based on the classificationId 
 let classificationList = document.querySelector("#classificationList"); 
 classificationList.addEventListener("change", function () { 
  let classificationId = classificationList.value; 
  console.log(`classificationId is: ${classificationId}`); 
  let classIdURL = "/phpmotors/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId; 
  fetch(classIdURL) 
  .then(function (response) { 
   if (response.ok) { 
    return response.json(); 
   } 
   throw Error("Network response was not OK"); 
  }) 
  .then(function (data) { 
   console.log(data); 
   buildInventoryList(data); 
  }) 
  .catch(function (error) { 
   console.log('There was a problem: ', error.message) 
  }) 
 })