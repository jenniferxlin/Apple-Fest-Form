<?php session_start();

$firstName = htmlspecialchars($_SESSION["firstname"]);
$lastName = htmlspecialchars($_SESSION["lastname"]);
$email = $_SESSION["email"];
$firstChoice = $_SESSION["firstChoice"];
$secondChoice = $_SESSION["secondChoice"];
$thirdChoice = $_SESSION["thirdChoice"];
$comments = htmlspecialchars($_SESSION["comments"]);?>

<!DOCTYPE html>
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

  <title>Apple Fest Poll</title>
</head>

<body>
  <?php include("includes/navigation.php"); ?>

  <div class="homebanner">
  <!--Image taken from Apple Fest's Facebook Event:
  https://www.facebook.com/downtownithaca/photos/gm.1199562176843168/10159285950480576/?type=3&theater-->
    <img src="images/apple-fest-poster.jpg" alt="Apple Fest Poster"/>
  </div>

  <h1 id="filled-out">Thank you <?php echo ($firstName); ?> <?php echo ($lastName); ?>
    for filling out our form. You have voted for <span id="votes"><?php echo ($firstChoice); ?>,
    <?php echo ($secondChoice); ?>, and <?php echo ($thirdChoice); ?></span>. And your comments have been submitted.
    We will update you with the final results at <?php echo ($email); ?>.
    We hope to see you at Apple Fest next year! </h1>

    <table>
      <tr>
        <td id="field"><p>Your Comments</p></td>
        <td id="value"><p><?php echo($comments); ?></p></td>
      </tr>
    </table>
</body>
</html>

  <?php include("includes/sponsors.php"); ?>

  <footer>
    <?php include("includes/socialmedia.php"); ?>

    <h5 id="disclaimer">Disclaimer: All information and images are taken from the
      <a href="http://www.downtownithaca.com/" target="_blank"> Downtown
      Ithaca</a> website unless otherwise noted. Other images are taken from the
      organization's respective websites that they are linked to.</h5>
  </footer>
  </body>
</html>
