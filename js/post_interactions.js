const DOWN = false;
const UP = true;

export function upvoteClick(button, downvotesMap) {
  if (isPressed(button)) {
    clicked(button, downvotesMap, DOWN, true);
  } else {
    clicked(button, downvotesMap, UP, false);
  }
}

export function downvoteClick(button, upvotesMap) {
  if (isPressed(button)) {
    clicked(button, upvotesMap, UP, true);
  } else {
    clicked(button, upvotesMap, DOWN, false);
  }
}

function clicked(button, opposites, type, pressed) {
  let alreadyVoted = false;
  if (pressed) {
    unpress(button);
  } else {
    press(button);
    alreadyVoted = isOppositePressed(button, opposites);
    if (alreadyVoted) {
      unpress(opposites.get(button.dataset.postId));
    }
  }
  updateOrInsertLike(button.dataset.postId, type, alreadyVoted);
}

function updateOrInsertLike(postId, typeVote, alreadyVoted) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/picsel/db/ajax_handling.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
      var response = JSON.parse(xhr.responseText);
      console.log(response);
      if (response.success) {
        return true;
      } else {
        console.error("Error: " + response.message);
      }
      console.log(xhr.responseText);
    }
  };

  var data = JSON.stringify({
    post_id: postId,
    type: typeVote,
    already_voted: alreadyVoted,
  });
  console.log(data);
  xhr.send(data);
}

function isOppositePressed(button, opposites) {
  return opposites.get(button.dataset.postId).classList.contains("pressed");
}

function isPressed(button) {
  return button.classList.contains("pressed");
}

function unpress(button) {
  button.classList.remove("pressed");
  colorInnerSvg(button, "var(--color-white)");
}

function press(button) {
  button.classList.add("pressed");
  colorInnerSvg(button, "var(--color-red)");
}

function colorInnerSvg(button, color) {
  let buttonInner = button.innerHTML;
  let parser = new DOMParser();
  let doc = parser.parseFromString(buttonInner, "application/xml");
  let svg = doc.getElementsByClassName("svg-inline--fa")[0];
  svg.style.color = color;
}
