import hex_sha512 from "./sha512.js";

let user = {
  name: document.getElementById("name"),
  username: document.getElementById("username"),
  email: document.getElementById("email"),
  password: document.getElementById("password"),
  confirmpassword: document.getElementById("confirmpassword"),
};

let error = {
  name: document.getElementById("nameerror"),
  username: document.getElementById("usernameerror"),
  email: document.getElementById("emailerror"),
  password: document.getElementById("passworderror"),
  confirmpassword: document.getElementById("confirmpassworderror"),
};

let signupform = document.getElementById("signupform");

window.addEventListener("DOMContentLoaded", () => {
  signupform.addEventListener("submit", async (e) => {
    e.preventDefault();
    let hasError = await signuperror();
    if (!hasError) {
      user.password.value = hex_sha512(user.password.value);
      user.confirmpassword.value = hex_sha512(user.confirmpassword.value);
      signupform.submit();
      alert("Signup Successful!");
    }
  });

  hideErrorOnClick(user.name, error.name);
  hideErrorOnClick(user.username, error.username);
  hideErrorOnClick(user.email, error.email);
  hideErrorOnClick(user.password, error.password);
  hideErrorOnClick(user.confirmpassword, error.confirmpassword);
});

async function signuperror() {
  await checkUsername();
  await checkEmail();
  checkName();
  checkPassword();
  checkConfirmPassword();
  return (
    error.name.style.visibility === "visible" ||
    error.username.style.visibility === "visible" ||
    error.email.style.visibility === "visible" ||
    error.password.style.visibility === "visible" ||
    error.confirmpassword.style.visibility === "visible"
  );
}

function checkName() {
  if (user.name.value === "") {
    showerror(user.name, error.name);
  } else {
    hideerror(user.name, error.name);
  }
}

async function checkUsername() {
  return new Promise((resolve, reject) => {
    if (user.username.value === "") {
      error.username.textContent = "Username not valid";
      showerror(user.username, error.username);
      resolve();
      return;
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/picsel/db/signupusernameajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
        let response = JSON.parse(xhr.responseText);
        if (response.success) {
          if (response.message === "In use") {
            error.username.textContent = "Username already in use";
            showerror(user.username, error.username);
          } else {
            hideerror(user.username, error.username);
          }
        } else {
          console.error("Error: " + response.message);
        }
        resolve();
      }
    };

    let data = JSON.stringify({
      username: user.username.value,
    });
    xhr.send(data);
  });
}

async function checkEmail() {
  return new Promise((resolve, reject) => {
    if (
      !user.email.value.match(
        /^[A-Za-z\._\-0-9]*[@][A-Za-z]*[\.][a-z]{2,4}$/
      ) ||
      user.email.value === ""
    ) {
      error.email.textContent = "Email not valid";
      showerror(user.email, error.email);
      resolve();
      return;
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/picsel/db/signupemailajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
        let response = JSON.parse(xhr.responseText);
        if (response.success) {
          if (response.message === "In use") {
            error.email.textContent = "Email already in use";
            showerror(user.email, error.email);
          } else {
            hideerror(user.email, error.email);
          }
        } else {
          console.error("Error: " + response.message);
        }
        resolve();
        return;
      }
    };

    let data = JSON.stringify({
      email: user.email.value,
    });
    xhr.send(data);
  });
}

function checkPassword() {
  if (user.password.value === "" || user.password.value.length < 8) {
    showerror(user.password, error.password);
  } else {
    hideerror(user.password, error.password);
  }
}

function checkConfirmPassword() {
  if (user.confirmpassword.value !== user.password.value) {
    showerror(user.confirmpassword, error.confirmpassword);
  } else {
    hideerror(user.confirmpassword, error.confirmpassword);
  }
}

function showerror(userparameter, errorname) {
  errorname.style.visibility = "visible";
  userparameter.style.border = " 1px solid var(--color-red)";
}

function hideerror(userparameter, errorname) {
  errorname.style.visibility = "hidden";
  userparameter.style.border = "1px solid var(--color-white)";
}

function hideErrorOnClick(userparameter, errorname) {
  userparameter.addEventListener("click", () => {
    hideerror(userparameter, errorname);
  });
}
