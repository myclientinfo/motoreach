<?php
if (isset($_POST["xhtml1"])) {
	$content = stripslashes($_POST["xhtml1"]);
} else {
	$content = "";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>XStandard XHTML 1.1 Editor</title>
		<script type="text/javascript">
		//<![CDATA[
			function myOnSubmitEventHandler() {
				try {
					if(typeof(document.getElementById('editor1').EscapeUnicode) == 'undefined') {
						throw "Error"
					} else {
						document.getElementById('editor1').EscapeUnicode = true;
						document.getElementById('xhtml1').value = document.getElementById('editor1').value;
					}			
				}
				catch(er) {
					document.getElementById('xhtml1').value = document.getElementById('alternate1').value;
				}
			}
		//]]>
		</script>
	</head>
	<body>
		<h1>XStandard XHTML 1.1 Editor</h1>
		<p>This page will post the data from the editor to itself (this page) and load the received data into the editor.  When the page reloads after you click the Submit button, the data in the editor should look exactly the same as before you clicked the Submit button.</p>

		<form action="xstandard.php" method="post" onsubmit="myOnSubmitEventHandler()">
			<p>
				<object type="application/x-xstandard" id="editor1" width="100%" height="400">
					<param name="Value" value="<?php echo htmlspecialchars($content, ENT_COMPAT) ?>" />
					<textarea name="alternate1" id="alternate1" cols="60" rows="15"><?php echo htmlspecialchars($content, ENT_COMPAT) ?></textarea>
				</object>
			</p>
			<p>	
				<input type="hidden" name="xhtml1" id="xhtml1" value="" /> 
				<input type="submit" id="btnAction" name="btnAction" value="Submit" />
			</p>
		</form>
	</body>
</html>
