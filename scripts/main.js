//REQUEST MULTI-SECTION FORMS
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("birthCertForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

document.getElementById("birthCertForm")?.addEventListener("submit", function (e){
    e.preventDefault();


    //NAVIGATE TO DELIVERY AND PAYMENT
    window.location.href = "delivery.html";

});

document.getElementById("birthCertForm")?.addEventListener("submit", async function (e) {
  e.preventDefault();

  // Collect the data from the form
  const formData = {
      lastName: document.getElementById("lastName").value,
      firstName: document.getElementById("firstName").value,
      middleName: document.getElementById("middleName").value,
      suffix: document.getElementById("suffix").value,
      sex: document.querySelector('input[name="sex"]:checked')?.value,
      birthday: document.getElementById("birthday").value,
      fatherLastName: document.getElementById("fatherLastName").value,
      fatherFirstName: document.getElementById("fatherFirstName").value,
      fatherMiddleName: document.getElementById("fatherMiddleName").value,
      fatherSuffix: document.getElementById("fatherSuffix").value,
      motherLastName: document.getElementById("motherLastName").value,
      motherFirstName: document.getElementById("motherFirstName").value,
      motherMiddleName: document.getElementById("motherMiddleName").value,
      birthPlace: document.getElementById("birthPlace").value,
      reqRelationship: document.getElementById("reqRelationship").value,
      reqLastName: document.getElementById("reqLastName").value,
      reqFirstName: document.getElementById("reqFirstName").value,
      reqMiddleName: document.getElementById("reqMiddleName").value,
      copies: document.getElementById("copies").value,
      reqPurpose: document.getElementById("reqPurpose").value,
  };

  try {
      // Send the form data to your Express.js backend
      const response = await fetch("/submit-birth-cert-form", {
          method: "POST",
          headers: {
              "Content-Type": "application/json",
          },
          body: JSON.stringify(formData),
      });

      if (response.ok) {
          // If submission is successful, navigate to the next page
          console.log("Data submitted successfully");
          window.location.href = "delivery.html";
      } else {
          console.error("Error submitting data:", response.statusText);
          alert("Error submitting data. Please try again.");
      }
  } catch (error) {
      console.error("Error submitting data:", error);
      alert("Error submitting data. Please check your network connection.");
  }
});
