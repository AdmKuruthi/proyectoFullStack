function validateSamePassword(){
    const pwd1 = document.querySelector("#psswrd1").value;
    const pwd2 = document.querySelector("#psswrd2").value;
    return pwd1 === pwd2;
}

function validateUsername(){
    const username = document.querySelector("#txt_username").value;
    const usernameRE = /^(?=.{3,20}$)(?![_.-])(?!.*[_.-]{2})[a-zA-Z0-9_-]+([^._-])$/;
    return usernameRE.test(username);
}

function validateEmail(){
    const username = document.querySelector("#txt_email").value;
    const usernameRE = /^(?=.{3,20}$)(?![_.-])(?!.*[_.-]{2})[a-zA-Z0-9_-]+([^._-])$/;
    return usernameRE.test(username);
}

function validateRegisterForm(){
    let errors=[];
    
    const email = document.querySelector("#txt_email").value;
    const password = validateSamePassword();

}

function displayErrors(errors){

}

if(window.location.href.contains("registroUsuario")){
    //document.querySelector("#psswrd2").addEventListener("blur",validateSamePassword);
    document.querySelector("#registroUsuario").addEventListener("blur",validateRegisterForm);
}