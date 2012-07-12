<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: index.php');
}

?>
<html>

<head>
<title>Secured Page</title>
</head>

<body>

<p>Welcome <b><?php echo $_SESSION['username']; ?></b></p>

<?php 
$test = array ("GameServer1", "GameServer2"); 

$count = count($test); 
echo "<table border='1' width='250'>";
$nrOfCells = 6; 
for($i = 0; $i <= $count; $i = $i + $nrOfCells) 
{ 
      echo "<tr>"; 
      for($z = 0; $z < $nrOfCells; $z++) 
      { 
          if($test[$i + $z] != NULL) 
                  echo "<td>{$test[$i + $z]}</td>"; 
            else 
                echo "<td>&nbsp;</td>"; 
      } 
      echo "</tr>"; 
} 
echo "</table>"; 
?>

<p><a href="logout.php">Logout</a></p>

</body>

</html>