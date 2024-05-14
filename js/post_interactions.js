const DOWN = false;
const UP = true;

export function upvoteClick(button, downvotesMap) {
    if (isPressed(button)) {
        clicked(button, downvotesMap, DOWN, true)
    } else {
        clicked(button, downvotesMap, UP, false)
    }
}

export function downvoteClick(button, upvotesMap) {
    if (isPressed(button)) {
        clicked(button, upvotesMap, UP, true)
    } else {
        clicked(button, upvotesMap, DOWN, false)
    }
}

function clicked(button, opposites, type, pressed) {
    let alreadyVoted = false;
    if (pressed) {
        unpress(button)
    } else {
        press(button)
        alreadyVoted = isOppositePressed(button, opposites)
        if (alreadyVoted) {
            unpress(opposites.get(button.dataset.postId))
        }
    }
    updateOrInsertLike(button.dataset.postId, type, alreadyVoted)
}

function updateOrInsertLike(postId, voteType, alreadyVoted) {
    fetch("/db/ajax_handling.php", {
        method: 'votePost',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({postId, voteType, alreadyVoted})
    })
    .then(response => response.json())
    .then(responseData => {
        let rowsAffected = responseData.rows
        console.log(`Number of rows affected: ${rowsAffected}`)
    })
    .catch(error => {
        console.error('Error:', error)
    })
}

function isOppositePressed(button, opposites) {
    return opposites.get(button.dataset.postId).classList.contains('pressed')
}

function isPressed(button) {
    return button.classList.contains('pressed')
}

function unpress(button) {
    button.classList.remove('pressed')
    colorInnerSvg(button, "var(--color-white)")
}

function press(button) {
    button.classList.add('pressed')
    colorInnerSvg(button, "var(--color-red)")
}

function colorInnerSvg(button, color) {
    let buttonInner = button.innerHTML
    let parser = new DOMParser()
    let doc = parser.parseFromString(buttonInner, 'application/xml')
    let svg = doc.getElementsByClassName("svg-inline--fa")[0]
    svg.style.color = color
}