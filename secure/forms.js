/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

function checkPassword(inputtxt)
{
	// at least one number, one lowercase and one uppercase letter
    // at least eight characters
	if (inputtxt.value.match(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/))
	{
		return true;
	}
	else {
		alert("Remember that your password has to consist of :\n- At least one number\n- One lowercase and one uppercase letter\n- At least eight characters");
		return false;
	}
}

function checkAndSubmit(form, password) {
	if (checkPassword(password))
	{
		form.p.value = hex_sha512(password.value);
		// Make sure the plaintext password doesn't get sent.
		password.value = "";
		return true;
	}
	else {
		return false;
	}
}
function checkAndSubmit2(form, password, password2) {
	
	if(password.value==password2.value)
	{
		res = checkAndSubmit(form, password);
		if(res)
		{
			password2.value = "";
		}
		return res;
	}
	else
	{
		alert("passwords are not equal");
		return false
	}
}
