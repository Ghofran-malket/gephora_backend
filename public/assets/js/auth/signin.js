const inputEmail = document.getElementById('EmailInput');
const inputPassword = document.getElementById('PasswordInput');
const btnSignin = document.getElementById('btn-signin');

btnSignin.addEventListener("click", checkCredentials);

function checkCredentials(){

    if(inputEmail.value == "test@mail.com" && inputPassword.value == "toto123"){
        //Il faudra récupérer le vrai token
        const token = "msdlkmdldfknskldfnosdfnksdfnklsdmkskldkmlskdkosadamsld";
        setToken(token);
        //placer ce token en cookie
        setCookie(roleCookieName, "admin", 7);
        window.location.replace("/");
    }else if(inputEmail.value == "client@mail.com" && inputPassword.value == "toto123"){
        //Il faudra récupérer le vrai token
        const token = "xcklmdlcmldmlfdmlvmdfkmvklmldcmldmcldmflmdflvmldfmklvfklkfvnk";
        setToken(token);
        //placer ce token en cookie
        setCookie(roleCookieName, "client", 7);
        window.location.replace("/");
    }
    else{
        inputEmail.classList.add("is-invalid");
        inputPassword.classList.add("is-invalid");
    }
}