window.addEventListener("DOMContentLoaded", () => {
  let form = document.getElementById("settings-form");

  form.addEventListener("submit", () => {
    let username = document.getElementById("nickname");
    let profilePic = document.getElementById("profile-picture").files[0];
    let name = document.getElementById("name");

    if (
      username.value.trim() === "" &&
      profilePic.files.length === 0 &&
      name.value.trim() === ""
    ) {
      alert(
        "Please enter a new name or username or select a new profile picture."
      );
      return;
    }
  });
});
