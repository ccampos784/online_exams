//Christopher Campos
function showallGrades() {
	//tell the user that we are loading the grades
	document.getElementById("grades").innerHTML = "<p>Loading grades...</p>";
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'https://web.njit.edu/~chc25/php/get_student_grades.php');
	xhr.onload = function() {
		document.getElementById("grades").innerHTML = xhr.responseText;
	}
	xhr.send();
}

function showgradeinfo(gradeID) {
	document.getElementById("grades").innerHTML = "<p>Loading grade information...</p>";
    var xhr = new XMLHttpRequest();
	xhr.open('POST', 'gradeinfo_s.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onload = function() {
		document.getElementById("grades").innerHTML = xhr.responseText;
       }
	xhr.send("gradeID=" + encodeURIComponent(gradeID));
}
