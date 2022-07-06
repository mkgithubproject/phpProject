//for register validation
function register() {
  let firstName = document.getElementById("Inputname1").value;
  let lastName = document.getElementById("Inputname2").value;
  let em = document.getElementById("InputEmail1").value;
  let pw1 = document.getElementById("InputPassword1").value;
  let pw2 = document.getElementById("InputPassword2").value;
  let user_firstname = 0;
  let user_lastname = 0;
  let pass_info1 = 0;
  let pass_info2 = 0;
  let email_info = 0;
  let username = /^[a-zA-Z]{1,}$/;
  let pass = /^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/;
  let eml = /^[A-Za-z0-9._]{3,}@[A-Za-z]{3,}[.][a-zA-Z]{3,}(.[a-zA-Z]{2,})?$/;
  if (username.test(firstName)) {
    document.getElementById("nameHelp1").innerHTML =
      "";
     
    user_firstname = 1;
    
  } else {
    document.getElementById("nameHelp1").innerHTML =
      "Invalid first name:username must only characters";
  }
  if (username.test(lastName)) {
    document.getElementById("nameHelp2").innerHTML =
      "";
    user_lastname = 1;
  } else {
    document.getElementById("nameHelp2").innerHTML =
      "Invalid last name:username must only characters";
  }
  if (pass.test(pw1)) {
    document.getElementById("passwordHelp1").innerHTML =
    "";
    pass_info1 = 1;
  } else {
    document.getElementById("passwordHelp1").innerHTML =
      "must contain 8 character at least one uppercase ,lower case ,numeric,and special character";
  }
  if (pw1 === pw2) {
    document.getElementById("passwordHelp2").innerHTML =
      "";
    pass_info2 = 1;
  } else {
    document.getElementById("passwordHelp2").innerHTML =
      "Password must be same like previous field";
  }
  if (eml.test(em)) {
    document.getElementById("emailHelp").innerHTML = "";
    email_info = 1;
  } else {
    document.getElementById("emailHelp").innerHTML = "Invalid email";
  }
  if (
    user_firstname == 1 &&
    user_lastname == 1 &&
    email_info == 1 &&
    pass_info1 == 1 &&
    pass_info2 == 1
  ) {
    return true;
  } else {
    return false;
  }
}

//for login validation
function login() {
  let em = (pw = 0);
  let email = document.getElementById("InputEmail1").value;
  let password = document.getElementById("InputPassword1").value;
  if (email.length==0) {
      (document.getElementById("emailHelp").innerHTML = "*Required");
  } else {
    document.getElementById("emailHelp").innerHTML = "";
    em = 1;
  }
  if (password.length==0) {
     (document.getElementById("passwordHelp").innerHTML = "*Required");
    
  } else {
    document.getElementById("passwordHelp").innerHTML = "";
    pw = 1;
  }
  if(em==1 && pw==1){
      return true;
  }
  else{
      return false;
  }
}
// for profile edit validation
function profile_edit() {
  let firstName = document.getElementById("Inputname1").value;
  let lastName = document.getElementById("Inputname2").value;
  let em = document.getElementById("InputEmail1").value;
  let username = /^[a-zA-Z]{1,}$/;
  let eml = /^[A-Za-z0-9._]{3,}@[A-Za-z]{3,}[.][a-zA-Z]{3,}(.[a-zA-Z]{2,})?$/;
  if (username.test(firstName)) {
    document.getElementById("nameHelp1").innerHTML =
      "";
     
    user_firstname = 1;
    
  } else {
    document.getElementById("nameHelp1").innerHTML =
      "Invalid first name:username must only characters";
      return false;
  }
  if (username.test(lastName)) {
    document.getElementById("nameHelp2").innerHTML =
      "";
    user_lastname = 1;
  } else {
    document.getElementById("nameHelp2").innerHTML =
      "Invalid last name:username must only characters";
      return false;
  }
   
  if (eml.test(em)) {
    document.getElementById("emailHelp").innerHTML = "";
    email_info = 1;
  } else {
    document.getElementById("emailHelp").innerHTML = "Invalid email";
    return false;
  }

  return true;
  
}



