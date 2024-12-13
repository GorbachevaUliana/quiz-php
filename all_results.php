<!DOCTYPE html>
<html>
<head>
<title>All Results</title>
</head>
<body>
<h1>All Results</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Score</th>
    </tr>
    <?php
	include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  $sql = "SELECT * FROM users";
  $result = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['score'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>


</body>
</html>
<?php

  mysqli_free_result($result);
  mysqli_close($link);
}

?>