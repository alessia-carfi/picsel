import * as sidemenu from "./sidemenu.js";
import * as opt from "./options.js";
import * as interactions from "./post_interactions.js";

let menu = null;
let image = null;
let close = null;
let shadow = null;
let topmenu = null;
let options = null;
let burger = null;

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

  //Setup post interactions
  //Map the buttons to their respective posts, and add their respective eventListeners
  let upvotes = document.getElementsByName("upvote")
  let upvotesMap = new Map();
  upvotes.forEach((b) => { 
    upvotesMap.set(b.dataset.postId, b) ;
    b.addEventListener("click", event => {
      interactions.upvoteClick(event.target, downvotesMap);
    });
  });

  let downvotes = document.getElementsByName("downvote");
  let downvotesMap = new Map();
  downvotes.forEach((b) => { 
    downvotesMap.set(b.dataset.postId, b);
    b.addEventListener("click", event => {
      interactions.downvoteClick(event.target, upvotesMap);
    });
  });

});
