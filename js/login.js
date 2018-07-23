// Christopher Campos - Group 2 - CS 490
// A JavaScript function that reads in UCID/Password from a form and POSTs it to a page
// Depending on the access level of the account, we send to different pages
function sendData() {
                var ucid = document.getElementById("ucid").value;
                var pass = document.getElementById("pass").value;
                var xhr = new XMLHttpRequest();

                xhr.open('POST', 'php/login_post.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                        //document.getElementById("resp").innerHTML = xhr.responseText;
                        var json_resp = JSON.parse(xhr.responseText);
                        if (json_resp.status === "true" && json_resp.idtype === "1") {
                                window.location.href = "php/instructor.php";
                        } else if (json_resp.status === "true" && json_resp.idtype === "2") {
                                window.location.href = "php/student.php";
                        } else {
                                window.location.href = "login_error.html";
               		}
                }
                xhr.send(encodeURI('ucid=' + ucid) + "&" + encodeURI('pass=' + pass) + "&");
}
