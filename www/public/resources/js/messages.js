let divMessage = $("#content");
let lastID = 0
let firstID = -1
let inputCreateMessage = $("input#message")
let time = 125
let salle = 0
let rooms = $("ul#rooms");

function createMessage(line) {
    lastID = Math.max(lastID, line.idMessage)
    const author = line.username;
    const userDiv = $("<div>")
    const messageDiv = $("<div>")
    userDiv.html("<h3>" + author + "</h3> <p class='date'>" + line.time + "</p>")
    userDiv.addClass("author")
    messageDiv.addClass("message")
    messageDiv.html(userDiv[0].outerHTML + line.content)
    return messageDiv;
}

function createHeaderRoom(room){
    console.log("Creating header for room " + room)
    let header = $("<div>")
    header.addClass("header")
    header.html("<h3>Salle "+room+"</h3><p>Ceci est le début de la salle " + room + "</p>")
    return header
}

function hasHeaderRoom(){
    return divMessage.children(".header").length > 0
}

function refreshMessages(idMessage,idSalle,last){
    console.log("Fetching messages : Message " + idMessage + " Salle " + idSalle + " Last? " + last)
    const previousScrollHeight = divMessage[0].scrollHeight;
    const previousScrollTop = divMessage.scrollTop();
    //request to get the last messages
    $.ajax("/api/messages/recuperer.php",{
        method:"GET",
        data:{
            "idSalle":idSalle,
            "idMessage":idMessage,
            "last":last
        },
    }).done(function(query){
        console.log(query)
        const message = query.data
        if(message.length > 0) {

            if (last === 0) {
                firstID = message[message.length - 1].idMessage
            }
            if(firstID === -1){
                firstID = message[0].idMessage
            }
            for (let i = 0; i < message.length; i++) {
                const line = message[i]
                const messageDiv = createMessage(line);
                if (last === 1) {
                    divMessage.append(messageDiv)
                } else {
                    divMessage.prepend(messageDiv)
                    time--;
                }
            }
        }
        if(last === 0){
            divMessage.scrollTop(previousScrollTop + (divMessage[0].scrollHeight - previousScrollHeight));
            if(message.length < 20 && !hasHeaderRoom())
                divMessage.prepend(createHeaderRoom(idSalle))
        }else{
            divMessage.scrollTop(divMessage[0].scrollHeight);
        }
        if(idMessage === 0 && last === 1 && message.length < 20 && !hasHeaderRoom()){
            divMessage.prepend(createHeaderRoom(idSalle))
        }
    }).fail(function(xhr) {
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



function newMessage(content,idSalle){
    console.log("Sending message : " + content + " at  " + idSalle)
    //request to get the last messages
    $.ajax("/api/messages/enregistrer.php",{
        method:"POST",
        data:JSON.stringify({            // Convert data to JSON string
            "idSalle": idSalle,
            "message": content,
            "idUser": 1
        }),
        contentType:"application/json"
    }).done(function(query){
        console.log(query)
        const message = query.data

        divMessage.append(createMessage(message[0]));
        divMessage.scrollTop(divMessage[0].scrollHeight);
        inputCreateMessage.val("")
    }).fail(function(xhr) {
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

divMessage.on("scroll",function(){
    if(divMessage.scrollTop() === 0) {
        console.log("Scrolling and loading oldest messages")
        refreshMessages(firstID, salle, 0)
    }
})
inputCreateMessage.on("keypress",function(event){
    if(event.key === "Enter"){
        console.log("Sending message")
        console.log(inputCreateMessage.val())
        newMessage(inputCreateMessage.val(),salle)
    }
})

rooms.children("li").on("click", function() {
    salle = $(this).attr("value");
    divMessage.empty()
    lastID = 0
    firstID = -1
    time = 125
    refreshMessages(0,salle,1)
});
// setInterval(() => refreshMessages(lastID,salle,1),2000)
// $(document).ready(() => refreshMessages(0,salle,1))