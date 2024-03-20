function openMenu() {
  var menu = document.getElementById("menu");
  var display = getComputedStyle(menu).display;
  if (display === "none") {
    display = "flex";
  } else {
    display = "none";
  }
}
