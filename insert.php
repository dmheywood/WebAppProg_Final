<?php
require_once("db_connect.php");

mysqli_select_db($conn,"DavidMHeywood");
// test the result to see if it succeeded

// if we are here, the SELECT was successful, so we can use
// that data. Chack below between the body tags

// List of variables
$photo = mysqli_real_escape_string($conn, $_POST['photo']);
$caption1 = mysqli_real_escape_string($conn, $_POST['caption1']); // must match named from itmes in the
$caption2 = mysqli_real_escape_string($conn, $_POST['caption2']); // HTML form. Example: name="answerText"
$author = mysqli_real_escape_string($conn, $_POST['author']);
if (empty($caption2)) {
	// send an error code as part of the url
	$locationString = "Location: index.php?error=noBottomCaption";
	// add on the values in the $_POST that the user did send here.
	// We'll name them the same as the $_POST names.
	// each one must start with & to fit the URL format.
	$locationString .= "&caption1=" . $caption1;
	$locationString .= "&author=" . $author;
	
	header($locationString);
}
else {

// set up the query (the SQL)
// every place there is a %s, we will use springf
//to replace the %s with an actual string value.
$insertQuery = "INSERT INTO `memeCreation`
(`imageId`, `caption1`, `caption2`, `author`)
VALUES 
('%s', '%s', '%s', '%s')";

// now use springf to substitute in the actual strings.
// springf expects:
// 1. a string (%insertQuery, in our case)
// 2. a list of items, the same number as the number of %s items.
$completeInsert = sprintf($insertQuery,
							$photo,
							$caption1,
							$caption2,
							$author							
							);

// test by var_dump
// if you see:
// false :  it means the srpintf failed, so look there.
// otherwise, if you see INSERT:
// check the VALUES area

// actually do the insert
mysqli_query($conn, $completeInsert);

$selectQuery = "SELECT `image` FROM `memeImages` WHERE `id`= '%s'";
$selectQuery = sprintf($selectQuery, $_POST['photo']); 
$selectResult = mysqli_query($conn, $selectQuery);
$row = mysqli_fetch_assoc($selectResult);
$photo = $row['image'];

// close the connection
mysqli_close($conn);
// end of test for $_POST['caption2'] being non-empty

// take us directly to the confirmation page
// so the user never sees the insert.php page
$locationString = "Location: complete.php";

// transfer the $_POST data into the URL parameters.
// Note: the FIRST parameter must start with ?
// Each other one starts with &
$locationString .= "?photo=" . $photo;
$locationString .= "&caption1=" . $caption1;
$locationString .= "&caption2=" . $caption2;
$locationString .= "&author=" . $author;
// now actually go to the URL that we built
header($locationString);
}
?>
