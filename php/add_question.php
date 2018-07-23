<?php
	include "prof_header.php";
?>

<h3>Please add a question below. Click "Submit" when you are done.</h3>
 <form onsubmit="sendData(); return false">
 <label for="question">Question:</label>
 <input type="text" id="question">
 <label for="difficulty">Difficulty:</label><br />
 <select id="difficulty"><option value="1">Easy</option>
 <option value="2">Medium</option>
 <option value="3">Hard</option></select><br />
 <label for="topic">Topic:</label>
 <input type="text" id="topic">
 <label for="functionname">Specify function name:</label>
 <input type="text" id="functionname">
 <label>Choose control structures:</label>
 <div><input type="checkbox" id="for" value="for"><label for="for">For loop</label>
 <input type="checkbox" id="while" value="while"><label for="while">While loop</label>
 <input type="checkbox" id="if_s" value="if"><label for="if_s">If statement</label></div>
 <input type="checkbox" id="print" value="print"><label for="print">Prints value instead of return</label></div>
 <p><h3>Test Cases:</h3></p><div id="inputs">
<div class="b_container"><input class="button" type="submit" value="Submit"></div></form>
