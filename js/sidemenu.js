export function openMenu(menu, topmenu, shadow) {
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
    menu.style.top = "0";

    topmenu.style.display = "flex";
    topmenu.style.flexDirection = "row";
    topmenu.style.justifyContent = "space-between";
    topmenu.style.cursor = "pointer";
    topmenu.style.alignItems = "center";
    topmenu.style.width = "90%";
    topmenu.style.padding = "1rem 1rem 0 1rem";

    shadow.style.display = "flex";
    shadow.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    shadow.style.position = "fixed";
    shadow.style.width = "100%";
    shadow.style.height = "100%";
    shadow.style.zIndex = "9";
  }
}

export function closeMenu(shadow, menu, topmenu) {
  shadow.style = "";
  menu.style = "display:none";
  topmenu.style = "display:none";
}

export function responsiveMenu(menu) {
  if (window.matchMedia("(max-width: 830px)").matches) {
    menu.style.display = "none";
  } else {
    menu.style.display = "flex";
  }
}
