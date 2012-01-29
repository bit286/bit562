<!DOCTYPE html>
<html>
	<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>fileReader.php Test</title>
			<style>
				.comment { color: red; }
			</style>
	</head>
	<body>
		<?php
			require_once('../Packager.php');
			require_once('../jsPackager.php');

			$jsPackager = new jsPackager();

			$lineComment1 = 'some code goes here // this is a line comment';
			$lineComment2 = '// this is a line comment';

			$lineFunction1 = 'var = function() {';
			$lineFunction2 = 'function junkfunction(var1, var2) {';

			$line1 = $jsPackager->packager($lineComment1, 0);
			$line2 = $jsPackager->packager($lineComment2, 0);
			$line3 = $jsPackager->packager($lineFunction1, 0);
			$line4 = $jsPackager->packager($lineFunction2, 0);

			echo "<p>comment 1 in:<br />$lineComment1</p>\n";
			echo "<p>comment 1 out:<br />$line1</p>\n";

			echo "<p>comment 2 in:<br />$lineComment2</p>\n";
			echo "<p>comment 2 out:<br />$line2</p>\n";

			echo "<p>function 1 in:<br />$lineFunction1</p>\n";
			echo "<p>function 1 out:<br />$line3</p>\n";

			echo "<p>function 2 in:<br />$lineFunction2</p>\n";
			echo "<p>function 2 out:<br />$line4</p>\n";
		?>
	</body>
</html>
