let subbtn = document.getElementById('subscribebuttonid');

let urlParams = new URLSearchParams(window.location.search);
let gameId = urlParams.get('game_id');

subbtn.addEventListener("click", () => {
    subscribeClick(subbtn);
});


function subscribeClick(button) {
    updateOrInsertSubscribe(button);
}


function updateOrInsertSubscribe(button) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/picsel/db/subscribe_ajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                if (button.classList.contains('subscribed')) {
                    unsubscribe(button);
                } else {
                    subscribe(button);
                }
            } else {
                console.error("Error: " + response.message);
            }
        }
    };

    let data = JSON.stringify({
        id: gameId
    });
    xhr.send(data);
}

function subscribe(button) {
    button.classList.remove("notsubscribed");
    button.classList.add("subscribed");
}

function unsubscribe(button) {
    button.classList.remove("subscribed");
    button.classList.add("notsubscribed");
}
