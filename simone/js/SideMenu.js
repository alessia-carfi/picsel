function openmenu() {
    var menu = document.getElementById("sidemenuid");
    var name = document.getElementById("nameid");
    if (menu.style.display === "none") {
      menu.style.display = "flex";
      name.style.display = "flex";
      name.style.flexDirection = "column";
      
    } else {
      menu.style.display = "none";
      name.style.display = "none";
    }
  }