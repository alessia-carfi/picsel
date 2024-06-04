import hex_sha512 from "./sha512.js";

let password = document.getElementById("passid");
let passworderror = document.getElementById("passworderrorid");
let email = document.getElementById("emailid");
let emailerror = document.getElementById("emailerrorid");

let loginform = document.getElementById("loginform");

hideErrorOnClick();

window.addEventListener("DOMContentLoaded", () => {
  loginform.addEventListener("submit", async (e) => {
    e.preventDefault();
    let hasError = await loginerror();
    if (!hasError) {
      password.value = hex_sha512(password.value);
      loginform.submit();
    }
    hideErrorOnClick();
  });
});

async function loginerror() {
  await checkLogin();
  return passworderror.style.visibility === "visible";
}

async function checkLogin() {
  return new Promise((resolve) => {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/picsel/db/loginajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
        try {
          var response = JSON.parse(xhr.responseText);
          if (response) {
            hideerror();
          } else {
            passworderror.textContent =
              "Invalid email or password. Please try again.";
            showerror();
          }
          resolve();
          return;
        } catch (e) {
          console.error("Parsing error:", e);
        }
      }
    };

    var data = JSON.stringify({
      email: email.value,
      password: hex_sha512(password.value),
    });
    xhr.send(data);
  });
}

function showerror() {
  passworderror.style.visibility = "visible";
  email.style.border = " 1px solid var(--color-red)";
  password.style.border = " 1px solid var(--color-red)";
}

function hideerror() {
  passworderror.style.visibility = "hidden";
  email.style.border = "1px solid var(--color-white)";
  passworderror.style.border = "1px solid var(--color-white)";
}

function hideErrorOnClick() {
  email.addEventListener("click", () => {
    email.style.border = "1px solid var(--color-blue)";
    passworderror.style.visibility = "hidden";
  });
  password.addEventListener("click", () => {
    password.style.border = "1px solid var(--color-blue)";
    passworderror.style.visibility = "hidden";
  });
}
