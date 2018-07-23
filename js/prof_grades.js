//Christopher Campos
function showallGrades() {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'https://web.njit.edu/~chc25/php/get_all_grades.php');
	xhr.onload = function() {
		document.getElementById("grades").innerHTML = xhr.responseText;
	}
	document.getElementById("grades").innerHTML = "<p>Loading grades...</p>";
	xhr.send();
}

function showgradeinfo(gradeID) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'gradeinfo_p.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onload = function() {
		document.getElementById("grades").innerHTML = xhr.responseText;
	}
	xhr.send("gradeID=" + encodeURIComponent(gradeID));
}

function updateComment(gradeID) {
	var comments = document.getElementsByName("comments");
        var i;
        for (i = 0; i < comments.length; i++) {
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'https://web.njit.edu/~chc25/php/relay_post.php');
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var questionID = comments[i].id;
			var comment = comments[i].value;
			xhr.onload = function() {
				var status = JSON.parse(xhr.responseText);
				if (status['status'] === 'false') {
					alert("An error updating the comments has occured.");
					return 1;
				}
			}
       		xhr.send("gradeID=" + encodeURIComponent(gradeID) + "&comment=" + encodeURIComponent(comment) + "&questionID=" + questionID + "&post_to=update_comment.php");
        }
	return 0;
}

function updateGrades(gradeID) {
	var grades = document.getElementsByName("s_grades");
	var i;
	for (i = 0; i < grades.length; i++) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'https://web.njit.edu/~chc25/php/relay_post.php');
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				var questionID = grades[i].id;
				var grade = grades[i].value;
		if (grade < 0) {
			alert("Grade cannot be less than 0! Please correct and try again.");
			return;
		}
		xhr.onload = function() {
			
			if (status['status'] === 'false') {
				alert("An error updating the grade has occured.");
				return 1;
			}
		}
		xhr.send("gradeID=" + encodeURIComponent(gradeID) + "&grade=" + encodeURIComponent(grade) + "&questionID=" + questionID + "&post_to=update_grade.php");
	}
	return 0;
}

function updateAll(gradeID) {
	var st_g = updateGrades(gradeID);
	var st_c = updateComment(gradeID);
	if (st_g == 0 && st_c == 0) {
		alert("All grades and comments have been updated successfully!");
	}	
	showallGrades();
}


function releaseGrade(gradeID, status) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'https://web.njit.edu/~chc25/php/relay_post.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onload = function() {
		var status = JSON.parse(xhr.responseText);
		if (status['status'] === 'true') {
			alert("This grade has been released.");
			showallGrades();
		}
		//alert(xhr.responseText);
	}
	xhr.send("gradeID=" + gradeID + "&release=" + status + "&post_to=release_s.php");
}

function sortGrades() {
		var sortby = document.getElementById("g_filter").value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_all_grades.php');
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var post_data = ""
        if (sortby === "released") {
                        post_data = "sortby=released";
                } else if (sortby === "not_released") {
                        post_data = "sortby=not_released";
                } else {
                        post_data = "";
                }
                
        xhr.onload = function() {
                document.getElementById("grades").innerHTML = xhr.responseText;
        };
		document.getElementById("grades").innerHTML = "<p>Loading grades...</p>";
        xhr.send(post_data);  
}
