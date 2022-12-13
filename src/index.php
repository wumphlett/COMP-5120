<?php
require "database.php";
$con = get_connection();
?>

<!DOCTYPE html>
<html>
<head>
  <title>DB Term Project</title>
  <link rel="stylesheet" href="style.css" type="text/css" media="all" />
</head>

<body>
  <div style="text-align: left; padding: 10px; border-bottom: solid gray">
    <h1 style="margin-bottom: 0;">Database Query Form</h1><h2>Will Humphlett (wh@auburn.edu)</h2>
  </div>


  <div style="margin-top: 20px">
    <button onclick="location.href='index.php';">All Tables</button>
    <button class="btn" onclick="location.href='query.php';">Query Database</button>
  </div>



<h2>All Tables</h2>
<?php
foreach($tables as $table_name) { ?>
  <h3><?= $table_name ?> </h3>
  <table class="bordered">
    <thead>
    <?php
    $query = "SELECT * FROM ". $table_name;
    $result = execute_query($con, $query);
    if(!$result) {
      die("Query failed to execute: " . mysqli_error($con));
    }
    //$books = mysqli_fetch_assoc($result);
    $num_fields = mysqli_num_fields($result);

    echo "<tr>";
    for($i = 0; $i < $num_fields; $i++) {
      $field = mysqli_fetch_field_direct($result, $i);
      echo "<th>" . $field->name . "</th>";
    }
    echo "</tr>";


    ?>
    </thead>

    <?php
    $rows = array();
    while($result_row = mysqli_fetch_assoc($result)) {
      $rows[] = $result_row;
    }
    foreach($rows as $row) {
      echo "<tr>";
      foreach($row as $col) {
        echo "<td>" . $col . "</td>";
      }
      echo "</tr>";
    }

    mysqli_free_result($result);

    ?>

  </table>

  <br><br>
<?php
}
?>
</body>
</html>
<?php mysqli_close($con); ?>