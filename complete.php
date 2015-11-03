<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Meme Complete</title>
</head>
<body>
<h1>Here is your new meme!</h1>
<p><a href="index.php">Back to the list of memes</a></p>
<img src="makeCaption.php?photo=<?php echo ($photo = $_GET['photo']) ?>&caption1=<?php echo ($caption1 = $_GET['caption1']) ?>
&caption2=<?php echo ($caption2 = $_GET['caption2']) ?>"/>
</body>
</html>