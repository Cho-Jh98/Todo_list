<!DOCTYPE html>


<?php
include("connectToDB.inc");
?>

<html>
  <head>
    <meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- name of the html -->
    <title Simple To-do list></title>
    <link rel="stylesheet" href="main.css">

    <?php
    if(isset($_POST['input_name'])){
      inserting_data();
    }
    if(isset($_POST['doing_del'])){
      doing_del_list($_POST['doing_del_id']);
    }
    if(isset($_POST['doing_done'])){
      doing_done_list($_POST['doing_done_id']);
    }
    if(isset($_POST['comp_del'])){
      comp_del_list($_POST['com_del_id']);
    }
    if(isset($_POST['comp_return'])){
      comp_return_list($_POST['com_rtn_id']);
    }

    if(isset($_POST['to_usr_prf'])){
      echo "<script>location.replace('user_profile.php');</script>";
    }
    if(isset($_POST['to_admin'])){
      echo "<script>location.replace('admin.php');</script>";
    }
    ?>
  </head>



  <body>
    <?php

    function inserting_data(){
      $dataBase = connectDB();

      $list_task = $_POST['input_text'];
      $list_usr_id = $_COOKIE['usr_id'];
      $DateAndTime = date("Ymd-his", time()); #20221202-164705
      $ins_date = date("Ymd", time());
      $list_id = $list_usr_id."-".$DateAndTime;
      setcookie("list_id", $list_id, time()+3600);
      $status = 0; # 0 for doing 1 for completed

      $query1 = "INSERT INTO list_data (list_id, usr_id, list_date, content, curr_status) VALUES ";
      $query = $query1 . "('" . $list_id . "', '" . $list_usr_id . "' ,'" . $ins_date . "', '" . $list_task . "', " . $status.")";

      mysqli_query($dataBase, $query) or die("Query failed: ".mysqli_error($dataBase));
      mysqli_close($dataBase);
    }

    function add_doing(){
      $dataBase = connectDB();

      $query1 = "SELECT list_id, content FROM list_data WHERE curr_status = 0 and usr_id = '";
      $query2 = $_COOKIE['usr_id'];
      $query = $query1.$query2."';";
      $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase));






      while($row = mysqli_fetch_row($result)){
        echo "<li id='".$row[0]."'><span>".$row[1]."</span>";
        $del_btn1 = "<form method = 'POST' type = '#'><input type = 'submit' class = 'btn' name = 'doing_del' value = '❌'></input>";
        $del_btn2 = "<input type = 'hidden' name = 'doing_del_id' value = '".$row[0]."' ></input></form>";

        $done_btn1 = "<form method='POST'><input type='submit' name='doing_done' value='✅' class = 'btn'></input>";
        $done_btn2 = "<input type = 'hidden' name = 'doing_done_id' value ='".$row[0]."'></input></form>";
        $del_btn = $del_btn1.$del_btn2;
        $done_btn = $done_btn1.$done_btn2;
        echo $del_btn;
        echo $done_btn;
        echo "</li>";
      }
      mysqli_close($dataBase);
    }

    function add_completed(){
      $dataBase = connectDB();

      $query1 = "SELECT list_id, content FROM list_data WHERE curr_status = 1 and usr_id = '";
      $query2 = $_COOKIE['usr_id'];
      $query = $query1.$query2."';";
      $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase));

      while($row = mysqli_fetch_row($result)){
        $del_btn1 = "<form method='POST' type = '#'><input type='submit' name='comp_del' value='❌' class = 'btn'></input>";
        $del_btn2 = "<input type = 'hidden' name = 'com_del_id' value ='".$row[0]."'></input></form>";
        $return_btn1 = "<form method='POST'><input type='submit' name='comp_return' value='⏪' class = 'btn'></input>";
        $return_btn2 = "<input type = 'hidden' name = 'com_rtn_id' value ='".$row[0]."'></input></form>";
        $del_btn = $del_btn1.$del_btn2;
        $return_btn = $return_btn1.$return_btn2;
        echo "<li id='".$row[0]."'><span>".$row[1]."</span>".$del_btn.$return_btn;

        echo "</li>";
       }
      mysqli_close($dataBase);
    }

    function doing_del_list($id){
      $dataBase = connectDB();

      $query1 = "DELETE FROM list_data WHERE list_id = '";
      $query = $query1.$id."';";
      $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase));
      mysqli_close($dataBase);
    }

    function comp_del_list($id){
      $dataBase = connectDB();

      $query1 = "DELETE FROM list_data WHERE list_id = '";
      $query = $query1.$id."';";
      $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase));
      mysqli_close($dataBase);

    }

    function doing_done_list($id){
      $dataBase = connectDB();
      $query1 = "UPDATE list_data SET curr_status=1 WHERE list_id='";
      $query = $query1.$id."';";
      $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase));
      mysqli_close($dataBase);
    }

    function comp_return_list($id){
      $dataBase = connectDB();
      $query1 = "UPDATE list_data SET curr_status=0 WHERE list_id='";
      $query = $query1.$id."';";
      $result = mysqli_query($dataBase, $query) or die('Query failed: '.mysqli_error($dataBase));
      mysqli_close($dataBase);
    }

    ?>

    <div id="wrap">
        <header>
          <h1 class="title">
            <img id="logo" src="mushroom.png">To-do List<img>
          </h1>
          <div class="clockContainer">
            <span class="clock">00:00:00</span>
          </div>
        </header>
      <?php
      $nick_result = $_COOKIE['nickname'];
      $greet = "Hello ".$nick_result."!";
      $echo_msg = "<h2 id='greetings'>".$greet."</h2>";
      echo $echo_msg;
      ?>


      <form class="input_form" method="POST" type = "#">
        <input id="input" type="text" name = "input_text" placeholder="Write what you have to do!">
        <input name="input_name" type="hidden">
      </form>
      <div>


        <div class = "profile_and_admin">
          <form method = "POST" action="usr_profile.php">
            <input type="submit" value="User Profile" />
            <input type="hidden" name = "to_usr_prf"/>
          </form>
          <?php
          $email = $_COOKIE['usr_email'];
          if ($email == "skfskfl9898@gmail.com"){
            echo "<form method = 'POST' action='admin.php' class = 'nav_page'>";
            echo "<input type='submit' value='Admin Page' class = 'nav_btn'/>";
            echo "<input type='hidden' name='to_admin' />";
            echo "</form>";
          }
          else if ($email == "dschincke@gmail.com"){
            echo "<form method = 'POST' action='admin.php class = 'nav_page''>";
            echo "<input type='submit' value='Admin Page' class = 'nav_btn'/>";
            echo "<input type='hidden' name='to_admin' />";
            echo "</form>";
          }
           ?>
        </div>

        <div class="list_category">

            <button class = "doing_button active" type="button">doing</button>
            <button class = "completed_button" type="button">completed</button>
          </div>
      </div>

      <div class="list_span">
        <ul class="doing_list visible">
          <?php
          add_doing();
          ?>
        </ul>
        <ul class="completed_list">
          <?php
          add_completed();
          ?>
        </ul>
      </div>



    </div>
  <script type="text/javascript" src="clock.js"></script>
  <script type="text/javascript" src="list_visible.js"></script>
  </body>

</html>
