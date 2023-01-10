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
<?php
include "classes/tradesman.php";
//get loggedin id and retrieve tradesmen profile.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (($_SESSION['actor']['is_tradesman'] == 0)) {

    if (isset($_POST['view-id'])) {
      $tId = $_POST['view-id'];
    }
    $isReadonly = 'readonly="readonly"';
  } else {

    echo "<br/><br/>You are logged in as a tradesman.  Please login as a user to search and view other tradesman profiles.";
    echo '<a href="view_tradesmen_profile.php">
    <input style="width:148px;" class="css-input-btn-login" type="submit" value="View Your Profile"/>
</a>';

    return;
  }

} else {
  $tId = $_SESSION['actor']['id'];
  $isReadonly = '';
}

$tradesman = new Tradesman();
$tradesman = $tradesman->retrieveProfile($tId);
$fName = $tradesman->getFName();
$lName = $tradesman->getLName();
$email = $tradesman->getEmail();
$contact = $tradesman->getContactNo();
$profRegNo = $tradesman->getProfessionalRegNo();
$tType = $tradesman->getTradeType();
$loc = $tradesman->getLocation();
$hourlyRate = $tradesman->getHourlyRate();
$skills = $tradesman->getSkills();

?>

<div class="t-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" src="img/tradesman-profile.png" alt="tradesman dp">
            <h3>
              <?php echo $fName . " " . $lName; ?>
            </h3>
          </div>
          <div class="card-body">
            <p class="mb-0"><strong class="pr-1">Tradesman ID:</strong> <?php echo $tId; ?> </p>
            <p <?php if (empty($profRegNo))
              echo 'style="display:none"'; ?> class="mb-0"><strong
                class="pr-1">Registration No:</strong>
              <?php echo $profRegNo; ?>
            </p>
            <p class="mb-0"><strong class="pr-1">Email:</strong> <?php echo $email; ?> </p>
            <p class="mb-0"><strong class="pr-1">Contact No:</strong>
              <?php echo $contact; ?>
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <form action="update_tradesman.php" method="post" class="form-signin" role="form">
          <div class="card shadow-sm">
            <div class="card-header bg-transparent border-0">
              <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Trade Information</h3>
            </div>
            <div class="card-body pt-0">
              <table class="table table-bordered">
                <tr>
                  <th width="30%">Trade Type</th>
                  <td width="2%">:</td>
                  <td><input <?php echo $isReadonly ?> type="text" name="trade_type" size="20" autofocus value="<?php if (isset($_POST['trade_type']))
                        echo $_POST['trade_type'];
                      else
                        echo $tType ?>"></td>
                  </tr>
                  <tr>
                    <th width="30%">Location </th>
                    <td width="2%">:</td>
                    <td><input <?php echo $isReadonly ?> type="text" name="location" size="20" value="<?php if (isset($_POST['location']))
                          echo $_POST['location'];
                        else
                          echo $loc ?>"></td>
                  </tr>
                  <tr>
                    <th width="30%">Hourly Rate (£)</th>
                    <td width="2%">:</td>
                    <td><input <?php echo $isReadonly ?> type="text" name="hour_rate" size="20" value="<?php if (isset($_POST['hour_rate']))
                          echo $_POST['hour_rate'];
                        else
                          echo $hourlyRate ?>"></td>
                  </tr>
                  <tr>
                    <th width="30%">Skills</th>
                    <td width="2%">:</td>
                    <td><input <?php echo $isReadonly ?> type="text" name="skills" size="20" value="<?php if (isset($_POST['skills']))
                          echo $_POST['skills'];
                        else
                          echo $skills ?>"></td>
                  </tr>

                </table>
              </div>
              <div class="button-section">
                <button <?php if ($_SESSION['actor']['is_tradesman'] == 0)
                          echo 'style="display:none"'; ?> class="sumit-btn"
                name="submit" type="submit">Update</button>
            </div>
          </div>

        </form>
        <!-- <div style="height: 26px"></div> -->
        <!-- <div class="card shadow-sm">
            <div class="card-header bg-transparent border-0">
              <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Other Information</h3>
            </div>
            <div class="card-body pt-0">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div> -->
      </div>
    </div>
  </div>
</div>


<?php

include('includes/footer.html');
?>