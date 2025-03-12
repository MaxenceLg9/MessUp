let buttonLogin = $("button#login")
let formLogin = $("form#login")
let buttonRegister = $("button#register")
let formRegister = $("form#register")

buttonLogin.on("click", function(e){
    e.preventDefault()
    console.log("Sending login request")
})

formLogin.on("keypress", function(e){
    e.preventDefault()
    if(e.keyCode === 13){
        console.log("Sending login request")
    }
})

buttonRegister.on("click", function(e){
    e.preventDefault()
    console.log("Sending register request")
})

formRegister.on("keypress", function(e){
    e.preventDefault()
    if(e.keyCode === 13){
        console.log("Sending register request")
    }
})

$(document).on("contextmenu", function(e) {
    return false;
});