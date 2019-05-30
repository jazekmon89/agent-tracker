<?php
$data = '';
$result = '';
$to_execute = '';
$lines_of_javascript = array();
/*$keywords = array(
	'var' => '$',
	'for' => 'for',
	'while' => 'while',
	'if' => 'if',
	'else' => 'else',
	'else if' => 'else if',
	'try' => 'try',
	'catch' => 'catch',
	'switch' => 'switch',
	'case' => 'case',
	'break' => 'break',
	'return' => 'return',
	'function' => 'function',
	'parseInt' => 'intval',
);*/
if (isset($_POST['data'])) {
	$data= $_POST['data'];
	$lines_of_javascript = getAllJavascriptLines($data);
	foreach ($lines_of_javascript as $line) {
		$keywords = explode(' ', $line);
		foreach ($keywords as $keyword) {
			if ($
			$result = 
		}
	}
} else if (isset($_POST['execute_php'])) {
	$to_execute = strip_tags($_POST['execute_php']);
	return eval($to_execute);
}

// this does not support ECMAScript 5
// we read lines by semi-colon/terminator
function getAllJavascriptLines($data) {
	$javascript_lines = explode(';', $data);
	return $javascript_lines;
}


?>
<html>
	<head>
		<title>JS to PHP converter</title>
		<style type="text/css">
			.scrollable {
				width: 250px;
				height: 200px;
				overflow: scroll;
			}
		</style>
	</head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<p>Javascript code:</p>
			<br />
			<textarea name="data">
				<?php echo $data; ?>
			</textarea>
			<br />
			<input type="submit" value="Convert!">
		</form>
		<br />
		<p>PHP Code:</p>
		<div class="scrollable" id="phpcode">
			<?php echo $result; ?>
		</div>
		<input type="button" onclick="showResult();" value="Output">
		PHP Code Output:
		<div class="scrollable" id="phpoutput">
		</div>
		<script type="text/javascript">
			function outputPHP() {
				var http = new XMLHttpRequest();
					var url = '<?php echo $_SERVER['PHP_SELF']; ?>';
					var params = 'execute_php='+document.getElementById('phpcode').textContent;
					http.open('POST', url, true);
					//Send the proper header information along with the request
					http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					http.onreadystatechange = function() {//Call a function when the state changes.
						if(http.readyState == 4 && http.status == 200) {
							//alert(http.responseText);
							document.getElementById('phpoutput').innerHTML = http.responseText;
						}
					}
					http.send(params);
			}
		</script>
	</body>
</html>