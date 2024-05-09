export function upvoteClick(button, downvotesMap) {
    if (button.classList.contains("pressed")) {
        
    } else {

    }
}
// REMINDER
// DO NOT add query to check if it was pressed, we're doing it in the other file
export function downvoteClick(button, upvotesMap) {
    console.log("BAnne")
    press(upvotesMap.get(button.dataset.postId))
}

function isOppositePressed(buttons) {

}

function unpress(button) {
    button.classList.remove('pressed')
    colorInnerSvg(button, "var(--color-white)")
}

function press(button) {
    button.classList.add('pressed')
    colorInnerSvg(button, "var(--color-red)")
}

function colorInnerSvg(button, color, id) {
    let buttonInner = button.innerHTML
    let parser = new DOMParser()
    let doc = parser.parseFromString(buttonInner, 'application/xml')
    let svg = doc.getElementsByClassName("svg-inline--fa")[0]
    svg.style.color = color
    console.log(svg.classList)
}