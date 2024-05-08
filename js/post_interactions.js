let upvote = document.getElementById("upvote")
let downvote = document.getElementById("downvote")

//Update upvote and downvote if one of them is pressed

upvote.addEventListener("click", event => {
    let button = event.target
    if (button.classList.contains('pressed')) {
        //Remove like from database and decrease counter
        unpress(button)
    } else {
        if (downvote.classList.contains('pressed')) {
            unpress(downvote)
        }
        press(button)
    }
})

downvote.addEventListener("click", event => {
    let button = event.target
    if (button.classList.contains('pressed')) {
        //Remove like from database and decrease counter
        unpress(button)
    } else {
        if (upvote.classList.contains('pressed')) {
            unpress(upvote)
        }
        press(button)
    }
})

function unpress(button) {
    button.classList.remove('pressed')
    button.style.color = "var(--color-white)"
}

function press(button) {
    button.classList.add('pressed')
    button.style.color = "var(--color-red)"
}