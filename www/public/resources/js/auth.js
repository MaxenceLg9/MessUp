let buttonLogin = $("button#login")
let formLogin = $("form#login")
let buttonRegister = $("button#register")
let formRegister = $("form#register")
let toggle = $("button#toggle")
let textToggle = $("p#toggle")

formRegister.toggle()

async function login(){
    try {
        const response = await $.ajax("/api/auth/", {
            method: "POST",
            contentType: "application/json", // Important for sending JSON
            data: JSON.stringify({
                "username": formLogin.find("input#username").val(),
                "password": formLogin.find("input#password").val()
                // "username" : "aaa",
                // "password": "bbb"
            })
        })
        console.log(response);
        Cookies.set("token", response.token);
        try{
            const page = await $.ajax("/",{
                method: 'GET',
                headers:{"Authorization": response.token}
            })
            console.log(page)
            document.open();
            document.write(page);
            document.close();
        }catch (xhr){
            console.log("Erreur lors de la recupération de la page")
            alert("La page n'a pas pu être récupérée")
        }
    } catch (xhr) {
        console.error(xhr.responseText);
        try {
            const json = JSON.parse(xhr.responseText);
            alert(json.response);
        } catch (e) {
            console.error("Could not parse response as JSON:", xhr.responseText);
            alert("An error occurred, but the response is not valid JSON.");
        }
    }
}

async function register(){
    try {
        const response = await $.ajax("/api/auth/", {
            method: "POST",
            contentType: "application/json", // Important for sending JSON
            data: JSON.stringify({
                "username": formRegister.find("input#username").val(),
                "password": formRegister.find("input#password").val(),
                "confirmpassword": formRegister.find("input#confirmpassword").val()
                // "username" : "aaa",
                // "password": "bbb"
            })
        })
        console.log(response);
        if(response.response === "OK"){
            alert("You have been registered successfully!")
            toggleForm()
        }
    } catch (xhr) {
        console.error(xhr.responseText);
        try {
            const json = JSON.parse(xhr.responseText);
            alert(json.response);
        } catch (e) {
            console.error("Could not parse response as JSON:", xhr.responseText);
            alert("An error occurred, but the response is not valid JSON.");
        }
    }
}

function toggleForm(){
    if(toggle.text() === "S'Inscrire"){
        toggle.text("Se Connecter")
        textToggle.text("Vous avez déjà un compte ?")
    } else {
        toggle.text("S'Inscrire")
        textToggle.text("Vous n'avez pas de compte ?")
    }
    formLogin.toggle()
    formRegister.toggle()
}

buttonLogin.on("click", async function(e){
    e.preventDefault()
    await login()
    console.log("Sending login request")
})

formLogin.submit(async function (e){
    e.preventDefault()
    await login()
    console.log("Sending login request")
})

buttonRegister.on("click", async function (e){
    e.preventDefault()
    await register();
    console.log("Sending register request")
})

formRegister.submit(async function (e){
    e.preventDefault()
    await register();
    console.log("Sending login request")
})

toggle.on("click", function(e){
    toggleForm()
})

/*
$(document).on("contextmenu", function(e) {
    return false;
});*/
