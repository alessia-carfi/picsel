const DOWN = false;
const UP = true;

buttonSetUp()

function buttonSetUp() {
  let upvotes = document.getElementsByName("upvote")
  let upvotesMap = new Map()
  upvotes.forEach((b) => { 
    upvotesMap.set(b.dataset.postId, b) 
  })

  let downvotes = document.getElementsByName("downvote");
  let downvotesMap = new Map();
  downvotes.forEach((b) => { 
    downvotesMap.set(b.dataset.postId, b);
    b.addEventListener("click", () => {
      downvoteClick(b, upvotesMap.get(b.dataset.postId));
    });
  });

  upvotes.forEach((b) => {
    b.addEventListener("click", () => {
      upvoteClick(b, downvotesMap.get(b.dataset.postId));
    });
  })

  let saves = document.getElementsByName("save")
  saves.forEach((s) => {
    s.addEventListener("click", () => {
      saveClick(s);
    })
  })
}

function saveClick(button) {
  if (button.classList.contains("liked")) {
    saveOrUnsavePost(button, "unsavePost")
  } else {
    saveOrUnsavePost(button, "savePost")
  }
}

function upvoteClick(button, opposite) {
  updateOrInsertLike(button, UP, opposite)
}

function downvoteClick(button, opposite) {
  updateOrInsertLike(button, DOWN, opposite)
}

function updateOrInsertLike(button, typeVote, opposite) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "/picsel/db/ajax_handling.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      if (response.success) {
        if (button.classList.contains('liked')) {
          unpress(button);
        } else {
          if (opposite.classList.contains('liked')) {
            unpress(opposite);
          }
          press(button);
        }
      } else {
        console.error("Error: " + response.message);
      }
    }
  };

  let data = JSON.stringify({
    method: "votePost",
    post_id: button.dataset.postId,
    type: typeVote
  });
  xhr.send(data);
}

function saveOrUnsavePost(button, method) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "/picsel/db/ajax_handling.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      if (response.success) {
        if (button.classList.contains('liked')) {
          unpress(button)
        } else {
          press(button)
        }
      } else {
        console.error("Error: " + response.message);
      }
    }
  };

  let data = JSON.stringify({
    method: method,
    post_id: button.dataset.postId
  });
  xhr.send(data);
  
}

function unpress(button) {
  button.classList.remove("liked");
  colorInnerSvg(button, "var(--color-white)");
}

function press(button) {
  button.classList.add("liked");
  colorInnerSvg(button, "var(--color-red)");
}

function colorInnerSvg(button, color) {
  let buttonInner = button.innerHTML;
  let parser = new DOMParser();
  let doc = parser.parseFromString(buttonInner, "application/xml");
  let svg = doc.getElementsByClassName("svg-inline--fa")[0];
  svg.style.color = color;
}

