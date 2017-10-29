<?php
  session_start();

  if(!isset($_SESSION['id'])) {
    header("Location:index.php?login");
    exit();
  }
  include 'dbh.php';
?>

<!DOCTYPE html>
<html lang = "en" >
<head>

  <title> Academy </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <!-- Import materialize.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script> 

  <link rel = "stylesheet" href = "style.css">
  <link rel = "icon" href = "ssd.png" >

  <!-- Import Font -->
  <link href="https://fonts.googleapis.com/css?family=Marcellus+SC" rel="stylesheet"> 
  <link href="https://fonts.googleapis.com/css?family=Simonetta:400i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet"> 
  <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet"> 

 <!-- Import Google Icon Font--> 
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  
</head>
<body>
  
  <!-- Import jQuery and then materialize.js--> 
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>

  <nav class ="head">
    <div class="nav-wrapper">
      <a class="brand-logo center">Academy</a>
      <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li><a href="leader.php"> leaderboard <i class="material-icons left">equalizer</i></a></li>
      </ul>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <?php
        include 'display_name.php';
      ?>
      </ul>
    </div>
  </nav>
  
  <!--  Dropdown Content -->
  <ul id="dropdown1" class="dropdown-content"> 
    <li><a href = "change.php" class="waves-effect waves-default " >change password</a></li>
    <li><a class="waves-effect waves-default " data-target = "modal4">guide</a></li>
  </ul>
      
  <nav class ="iq2">
    <div class="nav-wrapper">
      <a class="brand-logo center"> Share. Learn. Compete. Grow </a>
      
      <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li><a class="dropdown-button" href="#!" data-activates="dropdown1">HELP<i class="material-icons right">arrow_drop_down</i></a></li>
      </ul>
      
      <ul id="nav-mobile" class="right hide-on-med-and-down">


      <li><a class="waves-effect waves-default active" >DASHBOARD<i class="material-icons left">dashboard</i></a></li>
      <?php

        if(isset($_SESSION['id'])) {
          //echo $_SESSION['uid'];
          echo "<li><a href = 'logout.php' class ='waves-effect waves-default'><i class='material-icons left'>power_settings_new</i>LOGOUT</a></li>";
        } else {
           // echo "not logged in";
            echo "<li><a name = 'login' class='waves-effect waves-default' data-target = 'modal1'>LOGIN</a></li>"; 
        }
      ?> 

      </ul>
    
    </div>
  </nav>

  <br/><br/>

  <div class ="container">

    <div class="col s12"> 
   
    <?php
      include 'dbh.php';
      $users = "SELECT * FROM question";
      $result = mysqli_query($conn, $users);
      $isempty = true;
      $counter = 0;
      $users1 = "SELECT * FROM options";
          $result1 = mysqli_query($conn, $users1);
      $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      echo "";
      echo "</div>"; 

      function display($result){
        global $isempty;

        while($row = mysqli_fetch_assoc($result)) {
          $isempty = false;
          global $counter;
          $counter = $counter + 1;
          $counter1 = 1;
        /*  while ( $row22 = mysqli_fetch_assoc($result1) ){

            if ($row22['qid'] == $row['id']) {
              echo "<li>".$counter1.' '."  &emsp;".$row22['opt']."</li> ";
              $counter1 = $counter1 + 1;
            }
          }  */

          echo "<ul class='collapsible' data-collapsible='accordion'>
    <li>
      <div class='collapsible-header'><i class='material-icons'>star rate</i> Q. ".$counter."</div>
      <div class='collapsible-body'><span>".$row['ques']."</span></div>
    </li>
    
  </ul>";
        }
      }
      display($result);
      
    ?>
     
    </div>

  </div>

  <?php
    include 'modal.php';
  ?>

  <script>
   $(document).ready(function(){
      $('.modal').modal(); 
    }); 
    (function($) {
      $(function() {
        $('.dropdown-button').dropdown({
          inDuration: 300,
          outDuration: 225,
          hover: true, // Activate on hover
          belowOrigin: true, // Displays dropdown below the button
          alignment: 'right' // Displays dropdown with edge aligned to the left of button
        });
      }); // End Document Ready
    })(jQuery); // End of jQuery name space
</script>
<script>
  $(document).ready(function() {
    Materialize.updateTextFields();
  });
  </script>


<script>

var id;
$('form.ajax').on('submit', function(){
  var that = $(this),
      url = that.attr('action'),
      type = that.attr('method'),
      data = {};

  that.find('[name]').each(function(index, value) {
    var that = $(this),
        name = that.attr('name'),
        value = that.val();

        if (name == "id") {
          id = value;
        }
    data[name] = value;
  });

  $.ajax({
    url: url,
    type: type,
    data: data,
    success: function(response) {

        console.log(response);
        if (response == "we") {
          console.log(response);
          $('#' + id + 'message').html(""); 
          $('#' + id + 'name').html("");
          $('#' + id + 'name').attr('placeholder','You are out of tries');
          $('#' + id + 'name').attr('disabled','disabled');
          $('#' + id + 'up').attr('disabled','disabled');
        }
        else  if (response == "above") {
           $('#' + id + 'default').addClass("hid");
           $('#' + id + 'blank').remove();
            $('#' + id + 'name').html(" ");
          $('#' + id + 'message').html(" ");
          response = "<br><span class = 'red-text result col s6'> &emsp; &emsp;  Wrong answer. Try again.</span>";
           $('#' + id + 'message').html("<br><span class = 'white-text result col s6'> &emsp; &emsp;  Wrong answer. Try again.</span>");
          setTimeout(function() {
             $('#' + id + 'message').html(response);
          }, 200);

        }
        else if (response == "show"){
          var text = "<span class = 'red-text result col s6'> &emsp; &emsp; &emsp; Wrong answer. Try again.</span>";
           $('#' + id + 'message').html(" ");
           $('#' + id + 'message').html("<span class = 'white-text result col s6'> &emsp; &emsp; &emsp; Wrong answer. Try again.</span>");
           setTimeout(function() {
             $('#' + id + 'message').html(text);
          }, 200);
           $('#' + id + 'name').html(' ');
        } else if (response == "<span class = 'green-text result col s6 offset-s1'> Correct answer. +10 points. </span>") {
          $('#' + id + 'name').attr('disabled','disabled'); 
          $('#' + id + 'up').attr('disabled','disabled');
          $('#' + id + 'message').html(response);
        } else if (response == "<br><span class = 'green-text result col s6 '> &emsp;Correct answer. +20 points. </span>" ) {
          $('#' + id + 'name').attr('disabled','disabled');
           $('#' + id + 'giveup').attr('disabled','disabled');
          $('#' + id + 'up').attr('disabled','disabled');
          $('#' + id + 'message').html(response);
        } else if (response == "<span class = 'green-text result col s6 offset-s1'> Correct answer. +20 points. </span>") {
          $('#' + id + 'name').attr('disabled','disabled');
          $('#' + id + 'up').attr('disabled','disabled');   
        }
        else {
          $('#' + id + 'name').html(" ");
          $('#' + id + 'message').html(" ");
           $('#' + id + 'message').html("<br><span class = 'white-text result col s6'> &emsp; &emsp;  Wrong answer. Try aain.</span>");
          setTimeout(function() {
             $('#' + id + 'message').html(response);
          }, 200);

        }
        
    }
  });

  return false;
});

</script>

  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-100800312-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
