function formChange(elmntId)
{
    var elmnt = document.getElementById(elmntId);
}

function passwordShow()
{
    actualizeEye(1);
    var passwordEdit = document.getElementById("passwordEdit");
    passwordEdit.setAttribute("type", "text");
}

function passwordHide()
{
    actualizeEye(0);
    var passwordEdit = document.getElementById("passwordEdit");
    passwordEdit.setAttribute("type", "password");
}


function actualizeEye(mod)
{
    var eye = document.getElementById("passwordEye");

    if(mod == 0)
    {
        eye.classList = "fas fa-eye-slash";
    }
    else
    {
        eye.classList = "fas fa-eye";
    }
}
