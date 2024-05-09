export function upvoteClick(button, downvotesMap) {
    if (button.classList.contains("pressed")) {
        
    } else {

    }
}
// REMINDER
// DO NOT add query to check if it was pressed, we're doing it in the other file
export function downvoteClick(button, upvotesMap) {
    console.log("BAnne");
}

function isOppositePressed(buttons) {

}

function unpress(button) {
    button.classList.remove('pressed')
    button.style.color = "var(--color-white)"
}

function press(button) {
    button.classList.add('pressed')
    button.style.color = "var(--color-red)"
}