// Function to validate report form
function validateReportForm() {
  var brand = document.forms["reportForm"]["brand"].value;
  var model = document.forms["reportForm"]["model"].value;
  var color = document.forms["reportForm"]["color"].value;
  var description = document.forms["reportForm"]["description"].value;

  // Check if any field is empty
  if (brand == "" || model == "" || color == "" || description == "") {
    alert("All fields are required");
    return false;
  }
  return true;
}

// Function to validate login form
function validateLoginForm() {
  var email = document.forms["loginForm"]["email"].value;
  var password = document.forms["loginForm"]["password"].value;

  // Check if email and password are empty
  if (email == "" || password == "") {
    alert("Email and password are required");
    return false;
  }
  return true;
}

// Function to validate signup form
function validateSignupForm() {
  var email = document.forms["signupForm"]["email"].value;
  var password = document.forms["signupForm"]["password"].value;

  // Check if email and password are empty
  if (email == "" || password == "") {
    alert("Email and password are required");
    return false;
  }
  return true;
}
