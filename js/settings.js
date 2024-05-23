const form = null;
const username = null;
const profilePic = null;

window.addEventListener("DOMContentLoaded", () => {
  form = document.getElementById("settings-form");
  username = document.getElementById("nickname");
  profilePic = document.getElementById("profile-picture");

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    if (username.value.trim() === "" && profilePic.files.length === 0) {
      alert("Please enter a new username or select a new profile picture.");
      return;
    }

    form.submit();
  });
});
