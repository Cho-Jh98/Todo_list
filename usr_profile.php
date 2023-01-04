<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Muli'><link rel="stylesheet" href="AdminStyle.css">

  </head>

  <body>




    <div id="container">
      <header id = "first">
        <h1 style="font-size:6vw;">User Profile</h1>

      </header>
      <!-- returns to todo_list.php -->
      <a href="todo_list.php">
        <button>Return to ToDo List</button>
      </a><br><br>

      <?php
    include ("connectToDB.inc");

    //checks criteria for new nickname
    if (isset($_POST['newNickname'])) {
        updateNickname();
    }
    if (isset($_POST['newPassword'])) {
        updatePassword();
    }

    //function that allows user to update nickname
    function updateNickname() {
      //connects to database
      $dataBase = connectDB();
      //gets cookie
      $usr_id = $_COOKIE['usr_id'];
      //updates based on cookie and input
      $st1 = "UPDATE usr_info SET nickname = '";
      $st2 = mysqli_real_escape_string($dataBase, $_POST['newNickname']);
      $st3 = "'"." WHERE usr_ID = '$usr_id'";
      $query1 = $st1.$st2.$st3;

      $result1 = mysqli_query($dataBase, $query1) or die('Query failed: ' . mysqli_error($dataBase));

      //sets new cookie
      setcookie("nickname", $_POST['newNickname'], time() + 432000);

      //closes database
      $mysqli_close($dataBase);
    }

    //function that updates user password
    function updatePassword() {
        //connects to database
        $dataBase = connectDB();
        // gets cookie
        $usr_id = $_COOKIE['usr_id'];
        //updates user password
        $st1 = "UPDATE usr_info SET Pass_word = '";
        $st2 = mysqli_real_escape_string($dataBase, $_POST['newPassword']);
        $st3 = "'"." WHERE usr_ID = '$usr_id'";

        $query1 = $st1.$st2.$st3;

        $result1 = mysqli_query($dataBase, $query1) or die('Query failed: ' . mysqli_error($dataBase));
        //closes connection
        $mysqli_close($dataBase);
      }
    // form to update nickname
    echo <<<END
      <h2>Settings</h2>
      <form action="$_SERVER[PHP_SELF]" method="post">
        <p>Enter Your New Nickname: <input type="text" name="newNickname" value=""> </p>
        <input type='submit'>
      </form><br>
    END
    ;
      // form to update password
    echo <<<END
      <form action="$_SERVER[PHP_SELF]" method="post">
        <p>Enter Your New Password: <input type="text" name="newPassword" value=""> </p>
        <input type='submit'>
      </form><br>
    END
    ;

    ?>

    <?php
    //connection to database
    $dataBase = connectDB();
    $usr_id = $_COOKIE['usr_id'];
    //sql statement to get individual user counts for completed
    $sql1 = "SELECT * from list_data WHERE curr_status = 1 and usr_id = $usr_id";

    if ($result = mysqli_query($dataBase, $sql1)) {
        $rowcountD = mysqli_num_rows( $result );
    }
    // sql statment to get individual user counts for incomplete
    $sql2 = "SELECT * from list_data WHERE curr_status = 0 and usr_id = $usr_id";

    if ($result = mysqli_query($dataBase, $sql2)) {
        $rowcountND = mysqli_num_rows( $result );
    }
    // sets the graph with the data for a particular user.
    echo <<<END


    <div id="chartbox">
        <div id="sixthchart">
          <canvas id="barchart"></canvas>
        </div>

      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.1/chart.min.js" charset="utf-8"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" charset="utf-8"></script>

      <script>
    var ctx = document.getElementById("barchart").getContext("2d");

    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Incomplete", "Complete"],
            datasets: [{
                label: "Number of Complete and Incomplete tasks For All Users",
                data: [$rowcountND, $rowcountD],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)"
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)"
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    </script>

    </div>;
    END
    ;
    // closes database
    $mysqli_close($dataBase);

    ?>



  </body>
</html>
