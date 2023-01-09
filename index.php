<div class="container">
  <?php
  session_start();
  if (
    isset($_SESSION['actor']['first_name']) &&
    isset($_SESSION['actor']['last_name']) &&
    isset($_SESSION['actor']['id'])
  ) { // if the SESSION 'user_id' is  set...
    $userId = $_SESSION['actor']['id'];
    $page_title = "Welcome {$_SESSION['actor']['first_name']}";
    include('includes/loggedin_header.html');

    echo "You are now logged in, {$_SESSION['actor']['first_name']} {$_SESSION['actor']['last_name']}";

  } else {
    include('includes/header.html');
    require('login_tools.php');
    load();

    //include('includes/header.html');
  }


?>


  <div class="row">

    <div class="column">

      <div class="home-text-block">
        <h2>How work should work</h2>
        <p>Forget the old rules. You can have the best people. Right now. Right here. We take the hassle out of finding
          a great local builder or tradesman.</p>
      </div>

    </div>


    <div class="column">
      <img src="img/trade1.png" alt="Description of image" width="600" class="image-class">
    </div>

  </div>

  <div style="height: 105px;"></div>
</div>

<?php
include("includes/footer.html")
  ?>