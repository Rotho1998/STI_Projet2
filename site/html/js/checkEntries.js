function verifyPassword (isEditpassword = false) {
    const pwd = document.getElementById("inputPassword").value;
    if(isEditpassword && !pwd.localeCompare("")) {
        return true;
    }
    if(!pwd.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&.])[A-Za-z\d#$^+=!*()@%&.]{8,}$/)){
        document.getElementById("alertMessage").innerHTML = "Password must be at least 8 char long, should contain at " +
            "least one uppercase char, one lowercase char, one digit and one special char ($^+=!*()@%&.)";
        document.getElementById("alert").style.display = "block";
        document.getElementById("inputPassword").style.background = "pink";
        return false;
    } else {
        document.getElementById("alert").style.display = "none";
        document.getElementById("inputPassword").style.background = "white";
        return true;
    }
}