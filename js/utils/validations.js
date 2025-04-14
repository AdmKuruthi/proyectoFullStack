function validateSamePassword(){
    const pwd1 = document.querySelector("#psswrd1").value;
    const pwd2 = document.querySelector("#psswrd2").value;
    return pwd1 === pwd2;
}

function validateUsername(){
    const username = document.querySelector("#txt_username").value;
    const usernameRE = /^[a-zA-Z][a-zA-Z0-9_]{2,20}$/;
    return usernameRE.test(username);
}

function validateEmail(){
    const email = document.querySelector("#txt_email").value;
    const emailRE = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRE.test(email);
}

function validateRegisterForm(){
    let errors=[];
    
    validateSamePassword() ? null : errors.push("Las contraseñas no coinciden");
    validateUsername() ? null : errors.push("El nombre de usuario no es válido");
    validateEmail() ? null : errors.push("El correo electrónico no es válido");
    if(errors.length > 0){
        displayErrors(errors);
        return false;
    }

}

function displayErrors(errors){
    document.querySelector("#errorMessages").innerHTML = errors.join("<br>");
    document.querySelector("#errorMessages").parentElement.classList.remove("d-none");
    setTimeout(() => {
        document.querySelector("#errorMessages").innerHTML = "";
        document.querySelector("#errorMessages").parentElement.classList.add("d-none");
    }, 5000);
}

if(window.location.href.includes("registroUsuario")){
    //document.querySelector("#psswrd2").addEventListener("blur",validateSamePassword);
    document.querySelector("form").addEventListener("submit",validateRegisterForm);
    
}