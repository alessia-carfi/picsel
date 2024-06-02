import * as sidemenu from "./sidemenu.js";
import * as opt from "./options.js";
import * as searchbar from "./search.js";

let menu = null;
let image = null;
let close = null;
let shadow = null;
let topmenu = null;
let options = null;
let burger = null;
let profile = null;
let search = null;
let searchMobile = null;

function responsiveMenu(menu) {
  if (window.matchMedia("(max-width: 830px)").matches) {
    menu.style.display = "none";
  } else {
    menu.style.display = "flex";
  }
}

window.addEventListener("DOMContentLoaded", () => {
  menu = document.getElementById("sidemenuid");
  image = document.getElementById("profileimageid");
  close = document.getElementById("close");
  shadow = document.getElementById("shadowid");
  topmenu = document.getElementById("top-sidemenu");
  options = document.getElementById("optionsid");
  burger = document.getElementById("burger");
  profile = document.getElementById("profileid");
  search = document.getElementById("searchid");
  searchMobile = document.getElementById("search-mobile");

  image.addEventListener("click", () =>
    sidemenu.openMenu(menu, topmenu, shadow)
  );
  close.addEventListener("click", () =>
    sidemenu.closeMenu(shadow, menu, topmenu)
  );
  responsiveMenu(menu);
  responsiveMenu(options);

  burger.addEventListener("click", () => opt.openOptions(options, shadow));
  window.addEventListener("resize", () => responsiveMenu(menu));
  window.addEventListener("resize", () => responsiveMenu(options));
  searchMobile.addEventListener("click", () =>
    searchbar.openSearch(search, profile, searchMobile)
  );
  search.addEventListener("submit", () => {
    let text = document.getElementById("search-text");

    if (text.value.trim() === "") {
      return;
    }
  });
});
