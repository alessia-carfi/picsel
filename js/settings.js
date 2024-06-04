window.addEventListener("DOMContentLoaded", () => {
  let form = document.getElementById("settings-form");

  form.addEventListener("submit", (e) => {
    let username = document.getElementById("nickname");
    let name = document.getElementById("name");

    if (
      username.value.trim() === "" ||
      name.value.trim() === ""
    ) {
      e.preventDefault();
      alert(
        "Please enter a new name or username or select a new profile picture."
      );
    }else{
      alert("Profile updated successfully!");
    }
  });
});