<?php
// set some defaults for text field values
$defaultCaption1 = "";
$defaultAuthor = "";

require_once("db_connect.php");

mysqli_select_db($conn,"DavidMHeywood");

$selectQuery = "SELECT * FROM `memeImages`";
$selectResult = mysqli_query($conn, $selectQuery);
$prevMemeQuery = "SELECT
`memeImages`.`image` ,
`memeCreation`.`caption1` ,
`memeCreation`.`caption2`,
`memeCreation`.`author`
FROM
`memeImages` ,
`memeCreation`
WHERE
`memeCreation`.`imageID` = `memeImages`.`id`";
$prevMemeResult = mysqli_query($conn, $prevMemeQuery);

// test the result to see if it succeeded
if(!$selectResult) {
	die("Couldn't select from the memeImages table");
}
// if we are here, the SELECT was successful, so we can use
// that data. Chack below between the body tags
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Meme Generator</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<h1>Meme Machine</h1>
<div id="create">
  <h2>Create your own!</h2>
  <form action="insert.php" method="post">
    <?php
if($_GET['error'] == "noBottomCaption") {
	// set any values that the user typed before.
	$defaultCaption1 = $_GET['caption1'];
	$defaultAuthor = $_GET['author'];
?>
    <p>The bottom caption is REQUIRED in order for a Meme to be created</p>
    <?php
}
?>
    <h3>Step 1: Select Your Photo</h3>
    <fieldset id ="thumbnails">
      <?php 

while ($row = mysqli_fetch_assoc($selectResult)) {
	$numRecords = $numRecords + 1;	
	echo $numRecords; 
?>
      <div class="thumbnail">
        <?php
      if ($row['id'] == 1) {
		  $radioChecked = 'checked';
	  }
	 
	   ?>
        <input type="radio" name="photo" value="<?php echo($row['id']);?>" id="photo<?php echo($row['id']);?>" <?php echo($radioChecked);?>>
        <label for="photo<?php echo($row['id']);?>"> <span style="background-image:url(images/<?php echo($row['image']);?>)" title="<?php echo($row['title']);?>"></span></label>
      </div>
      <?php
}
?>
      <!-- there is a style already written for this class in styles.css -->
    </fieldset>
    <h3>Step 2: Type your top and bottom captions</h3>
    <label for="caption1">Top caption:</label>
    <input type="text" name="caption1" id="caption1" value="<?php echo($defaultCaption1);?>">
    <label for="caption2"><br>
      Bottom caption:</label>
      <?php
if($_GET['error'] == "noBottomCaption") {
	echo (" *Required field* ");
}
?>
    <input type="text" name="caption2" id="caption2">
    <h3>Step 3: Take credit!</h3>
    <p>
      <label for="author">My name is:</label>
      <input type="text" name="author" id="author" value="<?php echo($defaultAuthor);?>">>
    </p>
    <p><br>
      <input type="submit" value="Make my meme!">
    </p>
  </form>
</div>
<div id="completed">
  <h2>Previously created memes:</h2>
  <p>(click to see a larger version)</p>
  <!-- thumbnails of completed memes should go here.  Each one is a link that goes to a page with a bigger version. -->
  <ul>
    <?php
  while ($row = mysqli_fetch_assoc($prevMemeResult)) {
		?>
    <li> <a href="makeCaption.php?photo=<?php echo ($row['image']) ?>&caption1=<?php echo ($row['caption1']) ?>&caption2=<?php echo ($row['caption2']) ?>">
    <img src="makeCaption.php?photo=<?php echo ($row['image']) ?>&caption1=<?php echo ($row['caption1']) ?>&caption2=<?php echo ($row['caption2']) ?>&width=200&height=150"/>
    </a>(by <?php echo $row['author'] ?>) </li>
    <?PHP } ?>
  </ul>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>
