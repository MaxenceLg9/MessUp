let divMessage = $("#content");
let lastID = 0
let firstID = -1
let inputCreateMessage = $("input#message")
let time = 125
let salle = 1
let rooms = $("ul#rooms");
let btnDisconnect = $("li#disconnect")

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

async function refreshMessages(idMessage, idSalle, last) {
    console.log(`Fetching messages: Message ${idMessage}, Salle ${idSalle}, Last? ${last}`);

    const previousScrollHeight = divMessage[0].scrollHeight;
    const previousScrollTop = divMessage.scrollTop();

    try {
        const response = await $.ajax("/api/messages/recuperer.php", {
            method: "GET",
            data: {
                "idSalle": idSalle,
                "idMessage": idMessage,
                "last": last
            },
            headers: {"Authorization": Cookies.get("token")}
        });

        console.log(response);
        const messages = response.data;

        if (messages.length > 0) {
            if (last === 0) {
                firstID = messages[messages.length - 1].idMessage;
            }
            if (firstID === -1) {
                firstID = messages[0].idMessage;
            }
            for (const line of messages) {
                const messageDiv = createMessage(line);
                if (last === 1) {
                    divMessage.append(messageDiv);
                } else {
                    divMessage.prepend(messageDiv);
                    time--;
                }
            }
        }

        if (last === 0) {
            divMessage.scrollTop(previousScrollTop + (divMessage[0].scrollHeight - previousScrollHeight));
            if (messages.length < 20 && !hasHeaderRoom()) {
                divMessage.prepend(createHeaderRoom(idSalle));
            }
        }
        if (idMessage === 0 && last === 1 && messages.length < 20 && !hasHeaderRoom()) {
            divMessage.prepend(createHeaderRoom(idSalle));
        }

    } catch (xhr) {
        console.error(xhr.responseText);
        if(xhr.status === 401){
            alert("Vous avez été déconnecté")
            disconnect()
        }
        try {
            const json = JSON.parse(xhr.responseText);
            alert(json.response);
        } catch (e) {
            console.error("Could not parse response as JSON:", xhr.responseText);
            alert("An error occurred, but the response is not valid JSON.");
        }
    }
}



async function newMessage(content, idSalle) {
    console.log("Sending message:", content, "at", idSalle);

    try {
        const response = await $.ajax("/api/messages/enregistrer.php", {
            method: "POST",
            data: JSON.stringify({
                "idSalle": idSalle,
                "message": content,
            }),
            contentType: "application/json",
            headers: {"Authorization": Cookies.get("token")}
        });

        console.log(response);
        const message = response.data;

        divMessage.append(createMessage(message[0]));
        divMessage.scrollTop(divMessage[0].scrollHeight);
        inputCreateMessage.val("");

    } catch (xhr) {
        console.error(xhr.responseText);
        if(xhr.status === 401){
            alert("Vous avez été déconnecté")
            disconnect()
        }
        try {
            const json = JSON.parse(xhr.responseText);
            alert(json.response);
        } catch (e) {
            console.error("Could not parse response as JSON:", xhr.responseText);
            alert("An error occurred, but the response is not valid JSON.");
        }
    }
}

function disconnect(){
    Cookies.set("token","")
    window.location = "/auth.php"
}

divMessage.on("scroll",async function(){
    if(divMessage.scrollTop() === 0) {
        console.log("Scrolling and loading oldest messages")
        await refreshMessages(firstID, salle, 0)
    }
})
inputCreateMessage.on("keypress",async function(event){
    if(event.keyCode === 13){
        console.log("Sending message")
        console.log(inputCreateMessage.val())
        await newMessage(inputCreateMessage.val(),salle)
    }
})

rooms.children("li").on("click", async function() {
    salle = $(this).attr("value");
    divMessage.empty()
    lastID = 0
    firstID = -1
    time = 125
    await refreshMessages(0,salle,1)
    divMessage.scrollTop(divMessage[0].scrollHeight);
});

btnDisconnect.on("click",() =>{
    disconnect()
})


rooms.children("li").first().trigger("click");
setInterval(async () => await refreshMessages(lastID,salle,1),2000)
// $(document).ready(() => refreshMessages(0,salle,1))