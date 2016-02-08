var submitbutton = document.getElementById('submitbutton');
submitbutton.onclick = onSubmit;

function onSubmit() {
    var loginform = document.getElementById('form');
    var newPass1 = document.getElementById('newPass1');
    var newPass2 = document.getElementById('newPass2');
    
    newPass1.value = CryptoJS.SHA512(newPass1.value);
    newPass2.value = CryptoJS.SHA512(newPass2.value);

    loginform.submit();
}

