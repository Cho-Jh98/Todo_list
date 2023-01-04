<!DOCTYPE html>
<?php
include("connectToDB.inc");
?>
<html>

<head>
  <link rel="stylesheet" href="loginStyle.css"/>
  <title>Sign in</title>
  <?php
    if(isset($_POST["sign_up_name"])){
      add_usr_info();
    }
    if(isset($_POST["forgot_name"])){
      send_usr_psw();
    }
    if(isset($_POST["sign_in_name"])){
      sign_in();
    }
  ?>
</head>

<body>
<?php
  function add_usr_info(){
    $dataBase = connectDB();

    // Get data and preprocess the data
    $email = $_POST['NEW_EMAIL'];
    $password = $_POST['NEW_PASSWORD'];
    $nickname = $_POST['NEW_NICKNAME'];

    $q1= mysqli_real_escape_string($dataBase, $email)."','";
    $q2= mysqli_real_escape_string($dataBase, $password)."','";
    $q3= mysqli_real_escape_string($dataBase, $nickname);
    $q4= "');";

    // Make query for insert table
    $query1 = "INSERT INTO usr_info(E_mail,Pass_word,Nickname)";
    $query2 = " VALUES('";

    $dup_check1 = "SELECT count(*) FROM usr_info WHERE E_mail = '";
    $dup_check_query = $dup_check1.mysqli_real_escape_string($dataBase, $email)."';";

    $dup_check_result = mysqli_query($dataBase, $dup_check_query) or die('Query failed: '.mysqli_error($dataBase));

    // insert data or if duplicated, send error
    if((int)mysqli_fetch_array(mysqli_query($dataBase, $dup_check_query))[0] == 0){
      $query = $query1.$query2.$q1.$q2.$q3.$q4;
      $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase).$dup_check_query);
    }
    else {
      echo "<script>alert('Duplicated E-mail!')</script>";
    }
    mysqli_close($dataBase);
  }

  function send_usr_psw(){
    $dataBase = connectDB();
    $query1 = "UPDATE usr_info SET Pass_word = '1234' WHERE E_mail = '";
    $email = mysqli_real_escape_string($dataBase, $_POST['FORGOT_EMAIL']);
    $query = $query1.$email."';";
    $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase));

    echo "<script>alert('Your password has been change to 1234, Please change your password')</script>";

    mysqli_close($dataBase);
  }

  function sign_in(){
    $dataBase = connectDB();

    // Get data and preprocess the data
    $usr_email = $_POST['ID'];
    $usr_psw = $_POST['PASSWORD'];
    $query4 = mysqli_real_escape_string($dataBase, $usr_email)."';";

    // Make query for insert table
    $query1 = "SELECT Pass_word FROM usr_info WHERE E_mail = '";
    $query2 = "SELECT Nickname FROM usr_info WHERE E_mail = '";
    $query3 = "SELECT usr_ID FROM usr_info WHERE E_mail = '";

    $query_psw = $query1.$query4;
    $query_nick = $query2.$query4;
    $query_ID = $query3.$query4;

    // get data from database
    $q_psw = mysqli_query($dataBase, $query_psw) or die('Query failed1: '.mysqli_error($dataBase));
    $q_nick = mysqli_query($dataBase, $query_nick) or die('Query failed2: '.mysqli_error($dataBase));
    $q_ID = mysqli_query($dataBase, $query_ID) or die('Query failed3: '.mysqli_error($dataBase));

    $nick_result = mysqli_fetch_array(mysqli_query($dataBase, $query_nick))[0];
    $psw_result = mysqli_fetch_array(mysqli_query($dataBase, $query_psw))[0];
    $ID_result = mysqli_fetch_array(mysqli_query($dataBase, $query_ID))[0];

    // set a cookie for next page
    setcookie("nickname", $nick_result, time() + 432000);
    setcookie("usr_email", $usr_email, time() + 432000);
    setcookie("usr_id", $ID_result, time() + 432000);

    if ( is_null( $ID_result ) ) {
      // wrong email
      echo "<script>alert('No E-mail!')</script>";
    }
    else if((string)$psw_result == (string)$usr_psw){
      // correct email
      echo "<script>location.replace('todo_list.php');</script>";
    }
    else{
      // wrong password
      echo "<script>alert('Wrong Password!')</script>";
    }

    mysqli_close($dataBase);
  }


?>
  <div class="main">
    <p class="sign" align="center">Hello World!</p>
    <!-- log in -->
    <form class="enter" method="POST">
      <input class="un" name="ID" type="text" align="center" placeholder="Email"></input>
      <input class="pass" name="PASSWORD" type="password" align="center" placeholder="Password"></input>
      <input name="sign_in_name" type="hidden"></input>
      <input id = "sign_input" class = "submit" type = "submit" text-align="center">
    </form>


      <!-- forgot -->
      <div id="buttons">
        <button type="button" id="forgot_button">Forgot Password?</button>
        <div class = "forgot_background">
          <div class = "forgot_window">
            <div class = "forgot_popup">
                <!-- close button -->
              <div>
                <button type="button" id="forgot_close">❎</botton>
              </div>
              <!-- content -->
                <div class = "submit_email">
                  <p class="input_content">
                    Tell us your E-mail,<br> we will send your password via your email.</p>
                  <p>
                  <form method="POST">
                    <input type=text name="FORGOT_EMAIL" class="input_content" placeholder="email@domain.com"><br></input>
                    <input name="forgot_name" type="hidden"></input>
                    <input type="submit">
                  </form>

                  </p>
                </div>
              </form>
            <!-- end content -->
            </div>
         </div>
       </div>

       <!-- sign in -->
       <button type="button" id="sign_button">sign up?</button>

       <div class = "sign_background">
         <div class = "sign_window">
           <div class = "sign_popup">

              <!-- close button -->
              <div>
                <button type="button" id="sign_close">close</button>
              </div>

              <!-- content -->
              <div class = "submit_ID_PSW">
                <p class="input_content">
                  To sign in, submit your E-mail and password.<br>
                  Also make your nickname that we will call you.</p>

                <p>
                  <form method="POST">
                    <input class="input_content" name="NEW_EMAIL" type="email" placeholder="email@domain.com"><br></input>
                    <input class="input_content" name="NEW_PASSWORD" type="password" placeholder="create password"><br></input>
                    <input class="input_content" name="NEW_NICKNAME" type="text" placeholder="Uncle Sam"><br></input>
                    <input name="sign_up_name" type="hidden"></input>
                    <input type="submit">
                  </form>
                </p>
              </div>
              <!-- end content -->

            </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="login_script.js"></script>
</body>

</html>
