function toggleMenu() {
  const menu = document.getElementById("sidemenuid");
  const profile = document.getElementById("profile-mobile");
  const shadow = document.getElementById("shadowid");

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

    profile.style.display = "flex";
    profile.style.flexDirection = "row";
    profile.style.justifyContent = "start";
    profile.style.cursor = "pointer";
    profile.style.alignItems = "center";
    profile.style.margin = "1rem 0 0 1rem";

    shadow.style.display = "block";
    shadow.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    shadow.style.position = "fixed";
    shadow.style.width = "100%";
    shadow.style.height = "100%";
    shadow.style.zIndex = "9";
  }
}

window.addEventListener("DOMContentLoaded", () => {
  const image = document.getElementById("profileimageid");
  if (window.matchMedia("(max-width: 830px)").matches) {
    image.addEventListener("click", toggleMenu);
  }
});
