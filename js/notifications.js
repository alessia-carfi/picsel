let deleteButtons = document.getElementsByName("delete-notification");
deleteButtons.forEach(b => {
    b.addEventListener("click", () => {
        deleteNotif(b)
    })
})

function deleteNotif(button) {
    let xhr = new XMLHttpRequest()
    xhr.open("POST", "/picsel/db/ajax_handling.php", true)
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            let response = JSON.parse(xhr.responseText)
            if (response.success) {
                location.reload()
            }
            else {
                console.error("Error: " + response.message)
            }
        }
    }
        console.log(button.dataset.id)
    let data = JSON.stringify({
        method: "removeNotification",
        id: button.dataset.id
    })
    xhr.send(data)
}