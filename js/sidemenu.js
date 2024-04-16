let menu = null;
let image = null;
let close = null;
let shadow = null;
let top_menu = null;

function openMenu() {
  if (menu.style.display === "none") {
    menu.style.display = "flex";
    menu.style.flexDirection = "column";
    menu.style.position = "fixed";
    menu.style.alignItems = "start";
    menu.style.backgroundColor = "var(--color-blue)";
    menu.style.width = "80%";
    menu.style.height = "100%";
    menu.style.zIndex = "10";
    menu.style.borderRadius = "0 2rem 2rem 0";

    top_menu.style.display = "flex";
    top_menu.style.flexDirection = "row";
    top_menu.style.justifyContent = "space-between";
    top_menu.style.cursor = "pointer";
    top_menu.style.alignItems = "center";
    top_menu.style.width = "90%";
    top_menu.style.padding = "1rem 1rem 0 1rem";

    shadow.style.display = "flex";
    shadow.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    shadow.style.position = "fixed";
    shadow.style.width = "100%";
    shadow.style.height = "100%";
    shadow.style.zIndex = "9";
  }
}

function closeMenu() {
  shadow.style = "";
  menu.style = "display:none";
  top_menu.style = "display:none";
}

function responsiveMenu() {
  if (window.matchMedia("(max-width: 830px)").matches) {
    menu.style.display = "none";
  } else {
    menu.style.display = "flex";
  }
}

window.addEventListener("DOMContentLoaded", () => {
  image = document.getElementById("profileimageid");
  image.addEventListener("click", openMenu);
  close = document.getElementById("close");
  close.addEventListener("click", closeMenu);
  shadow = document.getElementById("shadowid");
  menu = document.getElementById("sidemenuid");
  top_menu = document.getElementById("top-sidemenu");
  responsiveMenu();
});

window.addEventListener("resize", responsiveMenu);
