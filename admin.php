<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Muli'><link rel="stylesheet" href="AdminStyle.css">

  </head>

  <body>




    <div id="container">
      <header id = "first">
        <h1 style="font-size:6vw;">Admin Page</h1>

      </header>
      <a href="todo_list.php">
        <button>Return to ToDo List</button>
      </a><br><br>

      <?php
    include ("connectToDB.inc");

    if (isset($_POST['tableName1']) && isset($_POST['attributeName1']) && isset($_POST['attributeValue1'])) {
      deleteRecords();
      showAllData();
    } else if (isset($_POST['tableName2']) && isset($_POST['attributeName2']) && isset($_POST['attributeValue2']) && isset($_POST['attributeName3']) && isset($_POST['attributeValue3'])) {
      updateRecords();
      showAllData();
    } else if (isset($_POST['usr_ID_value']) && isset($_POST['E_mail_value']) && isset($_POST['Pass_word_value']) && isset($_POST['Nickname_value'])) {
      insertRecordsUsers();
      showAllData();
    } else if (isset($_POST['list_id_value']) && isset($_POST['usr_id_value']) && isset($_POST['list_date_value']) && isset($_POST['content_value']) && isset($_POST['curr_status_value'])) {
      insertRecordsToDo();
      showAllData();
    } else {
      showAllData();
    }

    function showAllData() {
      $dataBase = connectDB();

      $query1  = 'SELECT * FROM usr_info';
      $result1 = mysqli_query($dataBase, $query1) or die('Query failed: '.mysqli_error($dataBase));
      echo "<br>All <i>User Information</i> Records:<br>";
      echo '<div class="tableFixHead1">';
      echo "<table border='1'>";
      echo "<thead><tr> <th>usr_ID</th> <th>E_mail</th> <th>Pass_word</th> <th>Nickname</th></tr></thead>";
      while ($line1 = mysqli_fetch_array($result1, MYSQL_ASSOC)) {extract($line1);
        echo "<tbody><tr> <td>$usr_ID</td> <td>$E_mail</td> <td>$Pass_word</td> <td>$Nickname</td></tr></tbody>";
      }
      echo "</table>";
      echo "</div>";

      $query2  = 'SELECT * FROM list_data';
      $result2 = mysqli_query($dataBase, $query2) or die('Query failed: '.mysqli_error($dataBase));

      echo "<br>All <i>List Data</i> Records:<br>";
      echo '<div class="tableFixHead2">';
      echo "<table border='1'>";
      echo "<thead><tr> <th>list_id</th> <th>usr_id</th> <th>list_date</th> <th>content</th><th>curr_status</th></tr></thead>";
      while ($line2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {extract($line2);
        echo "<tbody><tr> <td>$list_id</td> <td>$usr_id</td> <td>$list_date</td> <td>$content</td><td>$curr_status</td></tr></tbody>";
      }
      echo "</table>";
      echo "</div>";

      mysqli_close($dataBase);
    }

    function deleteRecords() {
      $dataBase = connectDB();
      $st1 = "DELETE FROM ";
      $st2 = mysqli_real_escape_string($dataBase, $_POST['tableName1']);
      $st3 = " WHERE ";
      $st4 = mysqli_real_escape_string($dataBase, $_POST['attributeName1']);
      $st5 = " = ";
      $q = "'";
      $st6 = mysqli_real_escape_string($dataBase, $_POST['attributeValue1']);
        $query1 = $st1.$st2.$st3.$st4.$st5.$q.$st6.$q;
      $result1 = mysqli_query($dataBase, $query1) or die('Query failed: ' . mysqli_error($dataBase));
      mysqli_close($dataBase);

    }

    function updateRecords() {
      $dataBase = connectDB();
      $q = "'";
      $st1 = "UPDATE ";
      $st2 = mysqli_real_escape_string($dataBase, $_POST['tableName2']);
      $st3 = " SET ";
      $st4 = mysqli_real_escape_string($dataBase, $_POST['attributeName2']);
      $st5 = " = ";
      $st6 = mysqli_real_escape_string($dataBase, $_POST['attributeValue2']);
      $st7 = " WHERE ";
      $st8 = mysqli_real_escape_string($dataBase, $_POST['attributeName3']);
      $st9 = " = ";
      $st10 = mysqli_real_escape_string($dataBase, $_POST['attributeValue3']);


        $query1 = $st1.$st2.$st3.$st4.$st5.$q.$st6.$q.$st7.$st8.$st9.$q.$st10.$q;


      $result1 = mysqli_query($dataBase, $query1) or die('Query failed: ' . mysqli_error($dataBase));

      mysqli_close($dataBase);
    }

    function insertRecordsUsers() {
      $dataBase = connectDB();
      $c = ', ';
      $q = "'";
      $st1 = "INSERT INTO usr_info VALUES (";
      $st2 = mysqli_real_escape_string($dataBase, $_POST['usr_ID_value']);
      $st3 = mysqli_real_escape_string($dataBase, $_POST['E_mail_value']);
      $st4 = mysqli_real_escape_string($dataBase, $_POST['Pass_word_value']);
      $st5 = mysqli_real_escape_string($dataBase, $_POST['Nickname_value']);
      $st6 = ")";


        $query1 = $st1.$q.$st2.$q.$c.$q.$st3.$q.$c.$q.$st4.$q.$c.$q.$st5.$q.$st6;

      $result1 = mysqli_query($dataBase, $query1) or die('Query failed: ' . mysqli_error($dataBase));

      mysqli_close($dataBase);
    }

    function insertRecordsToDo() {
      $dataBase = connectDB();
      $c = ', ';
      $q = "'";
      $st1 = "INSERT INTO list_data VALUES (";
      $st2 = mysqli_real_escape_string($dataBase, $_POST['list_id_value']);
      $st3 = mysqli_real_escape_string($dataBase, $_POST['usr_id_value']);
      $st4 = mysqli_real_escape_string($dataBase, $_POST['list_date_value']);
      $st5 = mysqli_real_escape_string($dataBase, $_POST['content_value']);
      $st6 = mysqli_real_escape_string($dataBase, $_POST['curr_status_value']);
      $st7 = ")";


        $query1 = $st1.$q.$st2.$q.$c.$q.$st3.$q.$c.$q.$st4.$q.$c.$q.$st5.$q.$c.$q.$st6.$q.$st7;

      $result1 = mysqli_query($dataBase, $query1) or die('Query failed: ' . mysqli_error($dataBase));

      mysqli_close($dataBase);
    }

    echo <<<END
      <h2>Below you can INSERT records in the <i>usr_info</i> table</h2>
      <form action="$_SERVER[PHP_SELF]" method="post">
        <p>usr_ID: <input type="text" name="usr_ID_value" value=""> </p>
        <p>E_mail: <input type="text" name="E_mail_value" value=""> </p>
        <p>Pass_word: <input type="text" name="Pass_word_value" value=""> </p>
        <p>Nickname: <input type="text" name="Nickname_value" value=""> </p>
        <input type='submit'>
      </form>
    END
    ;

    echo <<<END
      <h2>Below you can INSERT records in the <i>list_data</i> table</h2>
      <form action="$_SERVER[PHP_SELF]" method="post">
        <p>list_id: <input type="text" name="list_id_value" value=""> </p>
        <p>usr_id: <input type="text" name="usr_id_value" value=""> </p>
        <p>list_date: <input type="text" name="list_date_value" value=""> </p>
        <p>content: <input type="text" name="content_value" value=""> </p>
        <p>curr_status: <input type="text" name="curr_status_value" value=""> </p>
        <input type='submit'>
      </form>
    END
    ;

    echo <<<END
      <h2>Below you can DELETE records from the tables above</h2>
      <form action="$_SERVER[PHP_SELF]" method="post">
        <p>DELETE FROM <input type="text" name="tableName1" value=""> </p>
        <p>WHERE <input type="text" name="attributeName1" value="">  = <input type="text" name="attributeValue1" value=""> </p>
        <input type='submit'>
      </form>
    END
    ;

    echo <<<END
      <h2>Below you can UPDATE records in the tables above</h2>
      <form action="$_SERVER[PHP_SELF]" method="post">
        <p>UPDATE <input type="text" name="tableName2" value=""> </p>
        <p>SET <input type="text" name="attributeName2" value=""> = <input type="text" name="attributeValue2" value=""> </p>
        <p>WHERE <input type="text" name="attributeName3" value=""> = <input type="text" name="attributeValue3" value=""> </p>
        <input type='submit'>
      </form>
    END
    ;



    ?>

    <?php

    $dataBase = connectDB();

    $sql1 = "SELECT * from list_data WHERE curr_status = 1";

    if ($result = mysqli_query($dataBase, $sql1)) {
        $rowcountD = mysqli_num_rows( $result );
    }

    $sql2 = "SELECT * from list_data WHERE curr_status = 0";

    if ($result = mysqli_query($dataBase, $sql2)) {
        $rowcountND = mysqli_num_rows( $result );
    }

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
                label: "Number of tasks For Users",
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
    $mysqli_close($dataBase);
    ?>



  </body>
</html>
