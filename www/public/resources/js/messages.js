let div = $("#content");
let lastID = 0
let firstID = -1

function refreshMessages(idMessage,idSalle,last){
    console.log("Fetching messages : Message " + idMessage + " Salle " + idSalle + " Last? " + last)
    //request to get the last messages
    $.ajax("/api/messages/recuperer.php",{
        method:"GET",
        data:{
            "idSalle":idSalle,
            "idMessage":idMessage,
            "last":last
        }
    }).done(function(query){
        console.log(query)
        if(query.data.length > 0) {
            if (firstID === -1) {
                firstID = query.data[0].idMessage
            }
            if (last === 0) {
                firstID = query.data[0].idMessage
            }
            for (let i = 0; i < query.data.length; i++) {
                lastID = Math.max(lastID, query.data[i].idMessage)
                // firstID =
                const message = query.data[i]
                const author = message.author;
                const messageDiv = $("<div>")
                messageDiv.html(message.time + " " + author + " said </br>" + message.content)
                if (last === 1) {
                    div.append(messageDiv)
                }
                else
                    div.prepend(messageDiv)
            }
        }
    }).fail(function(xhr, status, error) {
        console.log(xhr.responseText);
        //pop up
        try {
            const json = JSON.parse(xhr.responseText); // Try parsing JSON
            alert(json.response); // Alert the 'response' key from the JSON
        } catch (e) {
            console.error("Could not parse response as JSON:", xhr.responseText);
            alert("An error occurred, but the response is not valid JSON.");
        }
    })
}

function newMessage(){

}

div.on("scroll",function(){
    if(div.scrollTop() === 0) {
        console.log("Scrolling and loading oldest messages")
        refreshMessages(firstID, 2, 0)
    }
})
setInterval(() => refreshMessages(lastID,2,1),2000)
$(document).ready(() => refreshMessages(0,2,1))