//Christopher Campos
function takeExam(testID, testName) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'take_exam.php');
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onload = function() {
		document.getElementById("test_area").innerHTML = xhr.responseText;
		var elements = document.getElementsByName("s_answer");
		var i;
		for (i=0; i < elements.length; i++) {
			el = elements[i];
			el.onkeydown = function(e) {
				if (e.keyCode === 9) { // tab was pressed

					// get caret position/selection
					var val = this.value,
						start = this.selectionStart,
						end = this.selectionEnd;

					// set textarea value to: text before caret + tab + text after caret
					this.value = val.substring(0, start) + '\t' + val.substring(end);

					// put caret at right position again
					this.selectionStart = this.selectionEnd = start + 1;

					// prevent the focus lose
					return false;

				}
			}
		}
	}
	document.getElementById("test_title").innerHTML = testName;
	document.getElementById("test_area").innerHTML = "Loading exam...";
	xhr.send("testID=" + testID);
} 

function getTests() {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "https://web.njit.edu/~chc25/php/get_exams.php");
	var allTests;
        xhr.onload = function() {
            document.getElementById("test_area").innerHTML = xhr.responseText;
	}
	xhr.send();
}

function gradeExam(testID, ucid) {
    var answers = document.getElementsByName("s_answer");
    var data = {}
    var i;
    for (i=0; i < answers.length; i++) {
        data[answers[i].id] = answers[i].value;
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "relay_post.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
		var result = xhr.responseText;
		alert("Your exam has been received. Once your instructor verifies and releases your scores, you can see your results in the \"Grades\" section.");
		//alert(xhr.responseText);
		document.getElementById("test_title").innerHTML = "Student Exams";
		getTests();
    }
    //alert(JSON.stringify(data));
    xhr.send("answer=" + encodeURIComponent(JSON.stringify(data)) + "&post_to=take_exam.php&testID=" + testID + "&ucid=" + ucid);
	
}
