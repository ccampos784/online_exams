//Christopher Campos
function showCreateExams(sortby) {
    var xhr = new XMLHttpRequest();
	xhr.open('POST', 'create_exam.php');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	var post_data = "";
        if (sortby === "topic") {
			post_data = "topic";
	} else if (sortby === "difficulty") {
			post_data = "difficulty";
	}

	xhr.onload = function() {
		document.getElementById("questions").innerHTML = xhr.responseText;
	};
	xhr.send("sortby=" + post_data);
}

function showaddExamForm() {
	var form_html = "<p>Fill out the form below and select the questions for the exam on the right. Click \"Submit\" once you are done.</p>";
	form_html += "<form onsubmit=\"sendData(); return false\">";
        form_html += "<label for=\"title\">Exam Title:</label>";
        form_html += "<input type=\"text\" id=\"title\">";
        form_html += "<label for=\"topic\">Topic:</label>";
        form_html += "<input type=\"text\" id=\"topic\"></form>";
        form_html += "<button type=\"button\" onclick=\"createExam()\">Submit</button>";
        document.getElementById("examForm").innerHTML = form_html;
        showCreateExams('none');
}

function createExam() {
	//get all the questions that have boxes checked -- these are questions selected for the test
	var questions = document.getElementsByName("q_checked");
	var count;
	var json = '{';
	//alert(questions.length);
	//start creating the json string that we will use to save the data
	for (count = 0; count < questions.length; count++) {
		if (questions[count].checked == true) {
			if (isDigit(document.getElementById("val_" + questions[count].value).value) == true)  {
				json += "\"" + questions[count].value + "\":\"" + document.getElementById("val_" + questions[count].value).value + "\", ";	
			} else {
				alert("There is an error! Make sure all questions are assigned a point value!");
				return;
			}
		}
	}
	json = json.slice(0, -2);
	json += '}';
	var xhr = new XMLHttpRequest();
	var testName = document.getElementById("title").value;
	var testTopic = document.getElementById("topic").value;
	if (testName === "") {
		alert("Error: Exam title is empty.");
		return;
	}
	if (testTopic === "") {
		testTopic = "None";
	}
	xhr.open('POST', "https://web.njit.edu/~chc25/php/relay_post.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var uriString = "testname=" + testName + "&topic=" + testTopic + "&data=" + json + "&post_to=add_test.php";
	//alert("DEBUG POST DATA: " + uriString);
	xhr.onload = function() {
		alert("Your exam has been created!");
		showExams();
	}
	xhr.send(uriString);
}

function showExams() {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "get_prof_exams.php");
	xhr.onload = function() {
		document.getElementById("examForm").innerHTML = "";
		document.getElementById("questions").innerHTML = xhr.responseText;
	}	     
	xhr.send();
}

function showExamInfo(testID) {      
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "examinfo.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
                document.getElementById("questions").innerHTML = xhr.responseText;
        }
        xhr.send("testID=" + testID);
}

function totalpoints(){
	var all_i = document.getElementsByName("q_points");
	i = 0;
	total = 0;
	for (i = 0; i < all_i.length; i++) {
		var field_val = Number(all_i[i].value);
		if (field_val < 0) {
			alert("Point value must be 0 or greater!");
			all_i[i].value = 0;
			continue;
		}
		total += Number(field_val);
	}
	document.getElementById("total_points").innerHTML = "<b>Total points: " + total + "</b>";
}   

// Check if a string consists of the digit characters (0-9)
function isDigit(str) {
    return str && !/[^\d]/.test(str);
}
