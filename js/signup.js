

let user = {
    name: document.getElementById('name'),
    username: document.getElementById('username'),
    email: document.getElementById('email'),
    password: document.getElementById('password'),
    confirmpassword: document.getElementById('confirmpassword'),
};

let error = {
    name: document.getElementById('nameerror'),
    username: document.getElementById('usernameerror'),
    email: document.getElementById('emailerror'),
    password: document.getElementById('passworderror'),
    confirmpassword: document.getElementById('confirmpassworderror'),
};

let signupform = document.getElementById("signupform");

window.addEventListener("DOMContentLoaded", () => {
    signupform.addEventListener("submit", (e) => {
        if (signuperror()) {
            e.preventDefault();
        } else {
            alert("Signup Successful!");
        }
    });
});



function signuperror() {

    nameerror();
    usernameerror();
    checkEmail();
    passworderror();
    confirmpassworderror();
    return error.name.style.visibility === "visible" || error.username.style.visibility === "visible" || error.email.style.visibility === "visible" || error.password.style.visibility === "visible" || error.confirmpassword.style.visibility === "visible";
}


function nameerror() {
    if (user.name.value === '') {
        showerror(user.name, error.name);
    } else {
        hideerror(user.name, error.name);
    }
}

function usernameerror() {
    if (user.username.value === '' || user.username.value.length < 3) {
        showerror(user.username, error.username);
    } else {
        hideerror(user.username, error.username);
    }
}

function checkEmail() {
    if (!user.email.value.match((/^[A-Za-z\._\-0-9]*[@][A-Za-z]*[\.][a-z]{2,4}$/)) || user.email.value === '') {
       error.email.textContent = "Email not valid";
       showerror(user.email, error.email);
       return;
    }
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/picsel/db/signupemailajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                if (response.message === "In use") {
                    error.email.textContent = "Email already in use";
                    showerror(user.email, error.email);
                    console.log("Email already in use");
                } else {
                    hideerror(user.email, error.email);
                }
            } else {
                console.error("Error: " + response.message);
            }
        }
    };

    var data = JSON.stringify({
        email: user.email.value,
    });
    xhr.send(data);
}



function passworderror() {
    if (user.password.value === '' || user.password.value.length < 8) {
        showerror(user.password, error.password);
    } else {
        hideerror(user.password, error.password);
    }
}

function confirmpassworderror() {
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
