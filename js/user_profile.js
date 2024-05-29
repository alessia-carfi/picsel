let followbtn = document.getElementById('followbuttonid');
let prname = document.getElementById('pr-nameid');
let prusername = document.getElementById('tagnameid');


window.addEventListener("DOMContentLoaded", async() => {
    pickUser();
});


function pickUser() {
    let urlParams = new URLSearchParams(window.location.search);
    let userId = urlParams.get('user_id');
    let myprofile = urlParams.toString().split('-')[1];
    if (myprofile === 'myprofile') {
        followbtn.style.display = 'none';
    }

    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/picsel/db/user_profileajax.php?user_id=' + userId, true);
    xhr.onload = function() {
        if (this.status == 200) {
            let user = JSON.parse(this.responseText);
            prname.textContent = user.name;
            prusername.textContent ="@"+user.nickname;
        }
    }
    xhr.send();
}
