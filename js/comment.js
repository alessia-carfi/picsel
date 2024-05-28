window.addEventListener("DOMContentLoaded", () => {
  let form = document.getElementById("create-comment");

  form.addEventListener("submit", () => {
    let comment = document.getElementById("comment-text");

    if (comment.value.trim() === "") {
      alert("You must enter a comment before submitting.");
      return;
    }
  });
});
