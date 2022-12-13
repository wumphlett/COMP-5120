<?php
require "database.php";
$con = get_connection();
if (!$con) {
    report_error(mysqli_error($con));
    die();
}

function report_error($msg) {
  echo '<div style="width: 100%; background: #f2dede; padding: 10px; border-radius: 5px">' . $msg . '</div>';
}
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
    <button onclick="location.href='query.php';">Query Database</button>
  </div>

<h2>Query Tables</h2>
<h4><?php echo implode(", ", $tables); ?></h4>
<div style="margin: 5px">
  <form method="POST" action="query.php">
    <textarea id="query" name="query" style="font-family: consolas; font-size: larger; width: 100%; height: 150px; border: 1px solid gainsboro; padding: 5px"><?= stripslashes($_POST["query"])?></textarea>
    <br />
    <input type="submit"/> <button type="button" onclick="document.getElementById('query').value = ''";>Clear</button>
  </form>
</div>

<div style="padding-top: 15px">

<?php
  if (isset($_POST["query"])) {
    $query = stripcslashes($_POST["query"]);
    $q = strtolower($query);
    $forbidden = array("drop", "delete", "update", "create", "alter");
    foreach($forbidden as $key) {
      if(strpos($q, $key) !== false) {
        report_error("DROP, DELETE, UPDATE, CREATE and ALTER statements are disallowed.");
        die();
      }
    }

    if ($query !== "") {
      $result = execute_query($con, $query);
      if ($result == false) {
        report_error(mysqli_error($con));
        die();
      }

      ?>
      <table class="bordered">
        <thead>
        <?php
        $numFields = mysqli_num_fields($result);

        echo "<tr>";
        for($i = 0; $i < $numFields; $i++) {
          $field = mysqli_fetch_field_direct($result, $i);
          echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        ?>
        </thead>

        <?php
        $rows = array();
        while($resultRow = mysqli_fetch_assoc($result)) {
          $rows[] = $resultRow;
        }
        foreach($rows as $row) {
          echo "<tr>";
          foreach($row as $col) {
            echo "<td>" . $col . "</td>";
          }
          echo "</tr>";
        }

        mysqli_free_result($result);
      }
      ?>
    </table>
  <?php
  }
?>
</div>

</body>
</html>
<?php mysqli_close($con); ?>