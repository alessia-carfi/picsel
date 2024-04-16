function openMenu() {
  const menu = document.getElementById("sidemenuid");
  const top = document.getElementById("top-sidemenu");
  const shadow = document.getElementById("shadowid");
  console.log(menu.style.display);
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

    top.style.display = "flex";
    top.style.flexDirection = "row";
    top.style.justifyContent = "space-between";
    top.style.cursor = "pointer";
    top.style.alignItems = "center";
    top.style.width = "90%";
    top.style.padding = "1rem 1rem 0 1rem";

    shadow.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    shadow.style.position = "fixed";
    shadow.style.width = "100%";
    shadow.style.height = "100%";
    shadow.style.zIndex = "9";
  }
}

["DOMContentLoaded", "resize"].forEach((event) =>
  window.addEventListener(event, () => {
    const image = document.getElementById("profileimageid");
    const menu = document.getElementById("sidemenuid");
    if (window.matchMedia("(max-width: 830px)").matches) {
      menu.style.display = "none";
      image.addEventListener("click", openMenu);
    }
  })
);

function closeMenu() {
  const menu = document.getElementById("sidemenuid");
  const shadow = document.getElementById("shadowid");
  menu.style.display = "none";
  shadow.style.display = "none";
}

["DOMContentLoaded", "resize"].forEach((event) =>
  window.addEventListener(event, () => {
    const close = document.getElementById("close");
    if (window.matchMedia("(max-width: 830px)").matches) {
      close.addEventListener("click", closeMenu);
    }
  })
);
