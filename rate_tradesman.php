<!--  -->

<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

</head>

<body>

</body>

</html>

<div id="review_modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Submit Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="text-center mt-2 mb-4">
          <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
          <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
          <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
          <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
          <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
        </h4>
       
        <div class="form-group">
          <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
        </div>
        <div class="form-group text-center mt-4">
          <button type="button" class="btn btn-primary" id="save_review">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function () {

    var rating_data = 0;

    $('#add_review').click(function () {

      $('#review_modal').modal('show');

    });

    $(document).on('mouseenter', '.submit_star', function () {

      var rating = $(this).data('rating');

      reset_background();

      for (var count = 1; count <= rating; count++) {

        $('#submit_star_' + count).addClass('text-warning');

      }

    });

    function reset_background() {
      for (var count = 1; count <= 5; count++) {

        $('#submit_star_' + count).addClass('star-light');

        $('#submit_star_' + count).removeClass('text-warning');

      }
    }

    $(document).on('mouseleave', '.submit_star', function () {

      reset_background();

      for (var count = 1; count <= rating_data; count++) {

        $('#submit_star_' + count).removeClass('star-light');

        $('#submit_star_' + count).addClass('text-warning');
      }

    });

    $(document).on('click', '.submit_star', function () {

      rating_data = $(this).data('rating');

    });

    $('#save_review').click(function () {
      var user_name = '<?php echo $userId; ?>';
      var tradesman_id = '<?php echo $tId; ?>';

      var user_review = $('#user_review').val();

      $.ajax({
        url: "submit_rating.php",
        method: "POST",
        data: { rating_data: rating_data, user_name: user_name, tradesman_id: tradesman_id, user_review: user_review },
        success: function (data) {

          $('#review_modal').modal('hide');
          window.location.reload();


        }
      })


    });


  });

</script>