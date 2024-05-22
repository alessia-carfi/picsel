const DOWN = false;
const UP = true;

function upvoteClick(button, opposite) {
  updateOrInsertLike(button, UP, opposite)
}

function downvoteClick(button, opposite) {
  updateOrInsertLike(button, DOWN, opposite)
}

function updateOrInsertLike(button, typeVote, opposite) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/picsel/db/ajax_handling.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
      var response = JSON.parse(xhr.responseText);
      console.log(response);
      if (response.success) {
        console.log(button.dataset.postId)
        console.log(opposite.dataset.postId)
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
      console.log(xhr.responseText);
    }
  };

  var data = JSON.stringify({
    post_id: button.dataset.postId,
    type: typeVote
  });
  console.log(data);
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

export function buttonSetUp() {
  let upvotes = document.getElementsByName("upvote")
  let upvotesMap = new Map();
  upvotes.forEach((b) => { 
    upvotesMap.set(b.dataset.postId, b) ;
  });

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
}
