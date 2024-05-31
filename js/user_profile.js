let followbtn = document.getElementById('followbuttonid');

let urlParams = new URLSearchParams(window.location.search);
let userId = urlParams.get('user_id');

followbtn.addEventListener("click", () => {
    followClick(followbtn);
});


function followClick(button) {
    updateOrInsertFollow(button);
}


function updateOrInsertFollow(button) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/picsel/db/follow_ajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                if (button.classList.contains('followed')) {
                    unfollow(button);
                } else {
                    follow(button);
                }
            } else {
                console.error("Error: " + response.message);
            }
        }
    };

    let data = JSON.stringify({
        id: userId
    });
    xhr.send(data);
}

function follow(button) {
    button.classList.remove("notfollowed");
    button.classList.add("followed");
}

function unfollow(button) {
    button.classList.remove("followed");
    button.classList.add("notfollowed");
}
