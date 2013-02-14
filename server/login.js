function Login(form) {
username = new Array("Colin","Ashley","Jonas","Zhong","Robert");
password = new Array("13","13","13","13","13");
page = "http://www.sfu.ca/~zhongl/cmpt275/cmpt275groupe13.html";
if (form.username.value == username[0] && form.password.value == password[0] || form.username.value == username[1] && form.password.value == password[1] || form.username.value == username[2] && form.password.value == password[2] || form.username.value == username[3] && form.password.value == password[3] || form.username.value == username[4] && form.password.value == password[4])
{
self.location.href = page;
}
else {
alert("Your input password is incorrect.\nPlease try again.");
form.username.focus();
}
return true;
}
