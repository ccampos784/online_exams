//Christopher Campos
function showaddQForm() {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'add_question.php');
	xhr.onload = function() {
		document.getElementById("qForm").innerHTML = xhr.responseText;
		var form_html = "";
		//input area 1
		form_html += "<label for=\"input1\">Input 1 (separate arguments with commas)</label>";
		form_html += "<input type=\"text\" id=\"input1\">";
		form_html += "<label for=\"output1\">Output 1</label><br />";
		form_html += "<textarea id=\"output1\" cols='55' rows='10'></textarea>";
		//input area 2
	        form_html += "<br /><label for=\"input2\">Input 2 (separate arguments with commas)</label>";
		form_html += "<input type=\"text\" id=\"input2\">";
		form_html += "<label for=\"output2\">Output 2</label><br />";
		form_html += "<textarea id=\"output2\" cols='55' rows='10'></textarea>";
		//input area 3
	        form_html += "<br /><label for=\"input2\">Input 3 (separate arguments with commas)</label>";
	        form_html += "<input type=\"text\" id=\"input3\">";
	        form_html += "<label for=\"output3\">Output 3</label><br />";
	        form_html += "<textarea id=\"output3\" cols='55' rows='10'></textarea>";
		//input area 4
	        form_html += "<br /><label for=\"input4\">Input 4 (separate arguments with commas)</label>";
	        form_html += "<input type=\"text\" id=\"input4\">";
	        form_html += "<label for=\"output4\">Output 4</label><br />";
	        form_html += "<textarea id=\"output4\" cols='55' rows='10'></textarea></div>";
		form_html += "<div class=\"b_container\"><input class=\"button\" type=\"submit\" value=\"Submit\"></div></form>";
		document.getElementById("inputs").innerHTML = form_html;
	}
	xhr.send();
}

function showQuestions(sortby) {
        var xhr = new XMLHttpRequest();
	xhr.open('POST', 'show_questions.php');
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
	

window.onload = showQuestions('none');

function sendData() {
    	var question = document.getElementById("question").value;
	var difficulty = document.getElementById("difficulty").value;
	var topic = document.getElementById("topic").value;
	var functionname = document.getElementById("functionname").value;
	var keywords = "";
    	var xhr = new XMLHttpRequest();

	//verify that the user entered all necessary fields
	if (question === "") {
		alert("Please provide a question!");
		return;
	}	
        if (topic === "") {
                topic = "None";
        }
        if (functionname === "") {
                alert("Please provide a function name!");
                return;
        }

	//get the keywords
	if (document.getElementById("for").checked) {
		keywords += "for,";
	}
        if (document.getElementById("while").checked) {
                keywords += "while,";
        }
        if (document.getElementById("if_s").checked) {
                keywords += "if,";
        }
	if (document.getElementById("print").checked) {
		keywords += "print,";
	}
	keywords = keywords.replace(/,\s*$/, "");

	//create an array of the input=>output test cases
	var arr_ans = {}; 
	var i;
	for (i = 1; i <= 4; i++) {
		if ( (document.getElementById("output" + i).value) !== "" ) {
			arr_ans[document.getElementById("input" + i).value] = document.getElementById("output" + i).value;
		}
	}
	var answer = JSON.stringify(arr_ans);

	if (answer === "{}") {
		alert("You must provide at least one test case.");
		return;
	}

	//we wil save the test cases as a json array for compatibilty reasons
        xhr.open('POST', 'relay_post.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
		var resp = JSON.parse(xhr.responseText);
		if (resp.status === "success") {
			alert("Your question was successfully added!");
			location.reload(); 
		}
		if (resp.status === "failed") {
                        alert("ERROR: Could not add question to bank!");
                }

	}
	xhr.send("question=" + encodeURIComponent(question) + "&answer=" + encodeURIComponent(answer) + "&difficulty=" + encodeURIComponent(difficulty) + "&topic=" + encodeURIComponent(topic) + "&post_to=add_question.php" + "&functionname=" + encodeURIComponent(functionname) + "&keywords=" + encodeURIComponent(keywords));

}
