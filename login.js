var submitbutton = document.getElementById('submitbutton');
submitbutton.onclick = onSubmit;

function onSubmit() {
    var loginform = document.getElementById('loginform');
    var password = document.getElementById('password');
    
    var hash = CryptoJS.SHA512(password.value);
    

    var passwordhashed = document.createElement("input");
    passwordhashed.type = "hidden";
    passwordhashed.name = "passwordhashed";
    passwordhashed.value = hash;
    
    loginform.appendChild(passwordhashed);
    password.parentNode.removeChild(password);
    loginform.submit();
}

