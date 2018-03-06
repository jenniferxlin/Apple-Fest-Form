<?php
//Get information about whether form has been submitted
$submit = $_REQUEST["submit"];

//Stores name of the class for hidden error messages
$hiddenErrors = "hiddenError";

//Stores name of the class for error messages if same dropdown options chosen
$hiddenErrorsUnique = "hiddenErrorUnique";

//Stores Comments
$comments = strip_tags($_REQUEST["comments"]);

//when the user submits form
if (isset($submit)) {
  //Retrieve first name input
  $firstName = filter_var($_REQUEST["firstName"], FILTER_SANITIZE_STRING);
  //If first name field isn't empty, then it is valid. Otherwise, it isn't.
  if (!empty($firstName)) {
    $firstNameValid = true;
  } else {
    $firstNameValid = false;
  }

  //Retrieve last name input
  $lastName = filter_var($_REQUEST["lastName"], FILTER_SANITIZE_STRING);
  //If last name field isn't empty, then it is valid. Otherwise it isn't.
  if (!empty($lastName)) {
    $lastNameValid = true;
  } else {
    $lastNameValid = false;
  }

  //Retrieve email input
  $email = $_REQUEST["userEmail"];
  //If email field isn't empty and is proper format, then it is valid. Otherwise it isn't.
  if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailValid = true;
  } else {
    $emailValid = false;
  }

  //Retrieve firstChoice input
  $firstChoice = $_REQUEST["firstChoice"];
  //If option isn't "Please Select" or the same as either second and/or third choice option, then it is valid.
  if ($firstChoice != "" && $firstChoice != $secondChoice && $firstChoice != $thirdChoice) {
    $firstChoiceValid = true;
  } else {
    $firstChoiceValid = false;
  }

  //Retrieve secondChoice input
  $secondChoice = $_REQUEST["secondChoice"];
  //If option isn't "Please Select" or the same as either first and/or third choice option, then it is valid.
  if ($secondChoice != "" && $secondChoice != $firstChoice && $secondChoice != $thirdChoice) {
    $secondChoiceValid = true;
  } else {
    $secondChoiceValid = false;
  }

  //Retrieve third Choice input
  $thirdChoice = $_REQUEST["thirdChoice"];
  //If option isn't "Please Select" or the same as either second and/or first choice option, then it is valid.
  if ($thirdChoice != "" && $thirdChoice != $firstChoice && $thirdChoice != $secondChoice) {
    $thirdChoiceValid = true;
  } else {
    $thirdChoiceValid = false;
  }

  //Form is valid if all required fields are valid
  $formValid = $firstNameValid && $lastNameValid && $emailValid &&
  $firstChoiceValid && $secondChoiceValid && $thirdChoiceValid;

  //If form valid, allow submit
  if ($formValid) {
    //Create session to send updated values to poll.php
    session_start();
    $_SESSION["firstname"] = $firstName;
    $_SESSION["lastname"] = $lastName;
    $_SESSION["email"] = $email;
    $_SESSION["firstChoice"] = $firstChoice;
    $_SESSION["secondChoice"] = $secondChoice;
    $_SESSION["thirdChoice"] = $thirdChoice;
    $_SESSION["comments"] = $comments;

    //redirects to poll page
    header("Location: poll.php");
    return;
  }
} else {
  //All fields are valid before submit is first pressed
  $firstNameValid = true;
  $lastNameValid = true;
  $emailValid = true;
  $firstChoiceValid = true;
  $secondChoiceValid = true;
  $thirdChoiceValid = true;
}
?>

<!DOCtype html>
<html>

<head>
  <meta charset="utf-8">
  <!--Resizes website to browser-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Links CSS to HTML-->
  <link href="styles/all.css" type="text/css" rel="stylesheet" media="all"/>
  <!-- Load jQuery -->
  <script src="scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
  <!-- Load validation -->
  <script src="scripts/clientValidation.js" type="text/javascript"></script>

  <title>Home</title>
</head>

<body>
  <!--Navigation bar -->
  <?php include("includes/navigation.php"); ?>

  <div class="homebanner">
  <!--Image taken from Apple Fest's Facebook Event:
  https://www.facebook.com/downtownithaca/photos/gm.1199562176843168/10159285950480576/?type=3&theater-->
    <img src="images/apple-fest-poster.jpg" alt="Apple Fest Poster"/>
  </div>

  <form action="index.php" method="post" id="appleForm" novalidate>
    <h1>~ Next Apple Dish to Debut ~</h1>
      <p>Thank you for another successful year of Apple Fest! Now that it's over,
        we need your help in choosing which new apple dishes we should introduce
        to the future vendor line-up. Fill out the form to pick which ones
        you want to see at next year's festival! All fields marked with
        <span class="star">*</span> are required.</p>

    <fieldset>
      <legend>Contact Information</legend>

      <!--First Name Field-->
      <div class="labels-errors">
        <div class="labels-inputs">
          <div class="labels">
            <label><span class="star">*</span> First Name:</label>
          </div>
          <div class="inputs">
            <input id="firstName" type="text" name="firstName" value="<?php echo($firstName); ?>" placeholder="example: &quot;Jill&quot;" required>
          </div>
          <span class="errorBox <?php if($firstNameValid) {echo("$hiddenErrors");} ?>"
            id="firstNameError"> First name must contain letters as shown in example.</span>
        </div>

        <!--Last Name Field-->
        <div class="labels-inputs">
          <div class="labels">
            <label><span class="star">*</span> Last Name:</label>
          </div>
          <div class="inputs">
            <input id="lastName" type="text" name="lastName" value="<?php echo($lastName); ?>" placeholder="example: &quot;Smith&quot;" required>
          </div>
          <span class="errorBox <?php if($lastNameValid) {echo("$hiddenErrors");} ?>"
             id="lastNameError"> Last name must contain letters as shown in example.</span>
        </div>

        <!--Email Field-->
        <div class="labels-inputs">
          <div class="labels">
            <label><span class="star">*</span> Email Address:</label>
          </div>
          <div class="inputs">
            <input id="userEmail" type="email" name="userEmail" value="<?php echo ($email); ?>"
            placeholder="name@domain.com" required>
          </div>
          <span class="errorBox <?php if($emailValid) {echo("$hiddenErrors");} ?>"
             id="emailError"> Invalid email address. Expected "@domain.com".</span>
        </div>
      </div>
    </fieldset>

    <fieldset>
      <legend>The New Apple Dishes</legend>

      <!--First Drop-down Choice-->
      <div class="choice">
      <h2><span class="star">*</span> First Choice</h2>
        <select id="firstChoice" name="firstChoice" required>
          <option value="">Please Select</option>
          <option name="applefries" value="Apple Cinnamon Ring Fries"
            <?php if($firstChoice =="Apple Cinnamon Ring Fries") {echo 'selected="selected"';}?>
            >Apple Cinnamon Ring Fries</option>
          <option value="Caramel Apple Spice Cake Pops"
            <?php if($firstChoice =="Caramel Apple Spice Cake Pops") {echo 'selected="selected"';}?>
            >Caramel Apple Spice Cake Pops</option>
          <option value="Apple Cider Float"
            <?php if($firstChoice =="Apple Cider Float") {echo 'selected="selected"';}?>
            >Apple Cider Float</option>
          <option value="Leftover Apple Pie in a Jar"
            <?php if($firstChoice =="Leftover Apple Pie in a Jar") {echo 'selected="selected"';}?>
            >Leftover Apple Pie in a Jar</option>
          <option value="Breakfast-Stuffed Apples"
            <?php if($firstChoice =="Breakfast-Stuffed Apples") {echo 'selected="selected"';}?>
            >Breakfast-Stuffed Apples</option>
          <option value="Caramel Apple Cheesecake Crepes"
            <?php if($firstChoice =="Caramel Apple Cheesecake Crepes") {echo 'selected="selected"';}?>
            >Caramel Apple Cheesecake Crepes</option>
        </select>
        <!--Error message for first choice-->
        <span class="errorBox <?php if($firstChoiceValid) {echo($hiddenErrors);} ?>"
          id="firstchoiceError">
          Please select a dish or pick a dish not previously selected.
        </span>
      </div>

      <!--Second Drop-down Choice-->
      <div class="choice">
      <h2><span class="star">*</span> Second Choice</h2>
        <select id="secondChoice" name="secondChoice" required>
          <option value="">Please Select</option>
          <option name="applefries" value="Apple Cinnamon Ring Fries"
            <?php if($secondChoice =="Apple Cinnamon Ring Fries") {echo 'selected="selected"';}?>
            >Apple Cinnamon Ring Fries</option>
          <option value="Caramel Apple Spice Cake Pops"
            <?php if($secondChoice =="Caramel Apple Spice Cake Pops") {echo 'selected="selected"';}?>
            >Caramel Apple Spice Cake Pops</option>
          <option value="Apple Cider Float"
            <?php if($secondChoice =="Apple Cider Float") {echo 'selected="selected"';}?>
            >Apple Cider Float</option>
          <option value="Leftover Apple Pie in a Jar"
            <?php if($secondChoice =="Leftover Apple Pie in a Jar") {echo 'selected="selected"';}?>
            >Leftover Apple Pie in a Jar</option>
          <option value="Breakfast-Stuffed Apples"
            <?php if($secondChoice =="Breakfast-Stuffed Apples") {echo 'selected="selected"';}?>
            >Breakfast-Stuffed Apples</option>
          <option value="Caramel Apple Cheesecake Crepes"
            <?php if($secondChoice =="Caramel Apple Cheesecake Crepes") {echo 'selected="selected"';}?>
            >Caramel Apple Cheesecake Crepes</option>
        </select>
        <!--Error message for second choice-->
        <span class="errorBox <?php if($secondChoiceValid) {echo($hiddenErrors);} ?>"
          id="secondchoiceError">
          Please select a dish or pick a dish not previously selected.
        </span>
      </div>

      <!--Third Drop-down Choice-->
      <div class="choice">
      <h2><span class="star">*</span> Third Choice</h2>
        <select id="thirdChoice" name="thirdChoice" required>
          <option value="">Please Select</option>
          <option name="applefries" value="Apple Cinnamon Ring Fries"
            <?php if($thirdChoice =="Apple Cinnamon Ring Fries") {echo 'selected="selected"';}?>
            >Apple Cinnamon Ring Fries</option>
          <option value="Caramel Apple Spice Cake Pops"
            <?php if($thirdChoice =="Caramel Apple Spice Cake Pops") {echo 'selected="selected"';}?>
            >Caramel Apple Spice Cake Pops</option>
          <option value="Apple Cider Float"
            <?php if($thirdChoice =="Apple Cider Float") {echo 'selected="selected"';}?>
            >Apple Cider Float</option>
          <option value="Leftover Apple Pie in a Jar"
            <?php if($thirdChoice =="Leftover Apple Pie in a Jar") {echo 'selected="selected"';}?>
            >Leftover Apple Pie in a Jar</option>
          <option value="Breakfast-Stuffed Apples"
            <?php if($thirdChoice =="Breakfast-Stuffed Apples") {echo 'selected="selected"';}?>
            >Breakfast-Stuffed Apples</option>
          <option value="Caramel Apple Cheesecake Crepes"
            <?php if($thirdChoice =="Caramel Apple Cheesecake Crepes") {echo 'selected="selected"';}?>
            >Caramel Apple Cheesecake Crepes</option>
        </select>

        <!--Error message for third choice-->
        <span class="errorBox <?php if($thirdChoiceValid) {echo($hiddenErrors);} ?>" id="thirdchoiceError">
          Please select a dish or pick a dish not previously selected.
        </span>
      </div>

      <h2>Other Suggestions</h2>
        <textarea name="comments" placeholder="Comment with new dishes or activities you want to see or any other feedback!"><?php if (isset($comments)) {echo(htmlspecialchars($comments));}?></textarea>
      <div class="poll-buttons">
        <input type="reset" name="reset" value="Reset">
        <input type="submit" name="submit" value="Submit">
      </div>
    </fieldset>
  </form>

  <!--Dates taken from Downtown Ithaca's website:
  http://downtownithaca.com/ithaca-events/2017%20Apple%20Harvest%20Festival%20Craft%20Application-->
  <div id="when">
    <div class="date-heading">
      <!--Image taken from IconArchive: http://www.iconarchive.com/show/small-n-flat-icons-by-paomedia/calendar-icon.html-->
      <img class="detail-logo" src="images/calendar-icon.jpg" alt="Calendar Icon"/>
      <h1 class="event-title">DATES</h1>
    </div>
    <div class="date-box">
      <h2 class="dates">September 29 (Friday, 12 - 6pm)</h2>
      <h2 class="dates">September 30 (Saturday, 10am - 6pm)</h2>
      <h2 class="dates">October 1 (Sunday, 10am - 6pm)</h2>
    </div>
  </div>


  <!--Address taken from Downtown Ithaca's website:
  http://www.downtownithaca.com/ithaca-events/35th%20Apple%20Harvest%20Festival%20Presented%20by%20Tompkins-->
  <div id="where">
    <div class="place-heading">
      <!--Image taken from IconShop: https://freeiconshop.com/icon/location-pin-icon-compact/-->
      <img class="detail-logo" src="images/location-marker.jpg" alt ="Location Marker"/>
      <h1 class="event-title">LOCATION</h1>
    </div>
    <div class="address-box">
      <h2 class="address">Ithaca Commons Pedestrian Mall</h2>
      <h2 class="address">202 East State St., Ithaca</h2>
    </div>
  </div>

  <!--Description modified from Downtown Ithaca's website:
  http://downtownithaca.com/ithaca-events/2017%20Apple%20Harvest%20Festival%20Craft%20Application-->
  <div class="brief-description">
    <h1>ALL ABOUT APPLES!</h1>
      <!-- Image taken from Clipart:
      http://cliparting.com/free-apple-clipart-1777/-->
      <img src="images/apples.jpg" alt="Apples"/>
      <p>The Downtown Ithaca Alliance is pleased to announce
        the 35th Annual Ithaca Apple Harvest Festival Presented by Tompkins Trust Company. 
        Last year, we attracted an audience of over 35,000 people, and this year
        we're expecting more! So come on down and enjoy Ithaca's premier event
        of the Fall, Apple Harvest Festival: a three day celebration of food,
        fun, and apples!</p>
  </div>

  <?php include("includes/sponsors.php"); ?>

  <footer>
    <?php include("includes/socialmedia.php"); ?>
    <h5 id="disclaimer">Disclaimer: All information and images are taken from the <a href="http://www.downtownithaca.com/" target="_blank"> Downtown
      Ithaca</a> website unless otherwise noted. Calendar Icon credit: <a href="http://www.iconarchive.com/show/small-n-flat-icons-by-paomedia/calendar-icon.html"
        target="_blank">IconArchive</a>, Location Icon credit: <a href="https://freeiconshop.com/icon/location-pin-icon-compact/"
        target="_blank">IconShop</a>, and Apples Icon credit: <a href="http://cliparting.com/free-apple-clipart-1777/" target="_blank">Clipart</a>.
        Other images are taken from the organization's respective websites that they are linked to.</h5>
  </footer>
</body>

</html>
