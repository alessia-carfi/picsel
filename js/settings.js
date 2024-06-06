window.addEventListener("DOMContentLoaded", () => {
  let form = document.getElementById("settings-form");

  form.addEventListener("submit", (e) => {
    let username = document.getElementById("nickname");
    let name = document.getElementById("name");
    let image = document.getElementById("profile-picture");

    if (
      username.value.trim() === "" &&
      name.value.trim() === "" &&
      image.files.length == 0
    ) {
      alert(
        "Please enter a new name or username or select a new profile picture."
      );
    }else{
      alert("Profile updated successfully!");
    }
  });
});