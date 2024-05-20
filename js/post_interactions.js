const DOWN = false;
const UP = true;

export function upvoteClick(button, downvotesMap) {
  updateOrInsertLike(button, UP, downvotesMap)
}

export function downvoteClick(button, upvotesMap) {
  updateOrInsertLike(button, DOWN, upvotesMap)
}

function updateOrInsertLike(button, typeVote, opposites) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/picsel/db/ajax_handling.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
      var response = JSON.parse(xhr.responseText);
      console.log(response);
      if (response.success) {
        if (button.classList.contains('liked')) {
          unpress(button);
        } else {
          opp = opposites.get(button.dataset.postId);
          if (opp.classList.contains('liked')) {
            unpress(opp);
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
