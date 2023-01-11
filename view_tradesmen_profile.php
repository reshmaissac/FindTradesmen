<div class="container">
  <?php
  include_once("session.php");
  loadViewProfilePermission();
  ?>
  <?php
  include "classes/tradesman.php";
  //get loggedin id and retrieve tradesmen profile.
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (($_SESSION['actor']['is_tradesman'] == 0)) {
      $userId = $_SESSION['actor']['id'];
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

  include_once("classes/rating.php");
  $rating = new Rating();
  $rating->setTId($tId);
  $avgRating = $rating->retrieveAvgRatings();

  ?>

  <div class="t-profile py-4">

    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" src="img/tradesman-profile.png" alt="tradesman dp">
            <h3>
              <?php echo $fName . " " . $lName; ?>
            </h3>
            <h4 class="text-warning mt-4 mb-4">
              <b><span id="average_rating"><?php echo round($avgRating, 1); ?></span> / 5</b>
            </h4>
          </div>
          <div class="card-body">

            <p class="mb-0"><strong class="pr-1">Tradesman ID:</strong>
              <?php echo $tId; ?>
            </p>
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
            <div <?php if ($_SESSION['actor']['is_tradesman'] == 1)
              echo 'style="display:none"'; ?>class="col-sm-4 text-center">
              <button type="button" name="add_review" id="add_review" class="btn btn-primary">Rate</button>
            </div>
          </div>


        </form>


      </div>
    </div>

  </div>


  <?php
  include("rate_tradesman.php");
  include('includes/footer.html');
  ?>


</div>
<!--  -->