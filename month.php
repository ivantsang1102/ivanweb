<?php
$con = mysqli_connect('localhost','tcf','134889','hsi');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>恆指月結圖</title>
  <?php include 'website/header.php'; ?>
	<style type="text/css">
    
		@media screen and (max-width: 812px) {

			img {
				max-width:100%;
				height: auto;
			}
		}

		
	</style>
</head>
<body>


    <div class="container">

      <?php
      $result=mysqli_query($con, "select * from hsi.image order by id DESC");
      while($rows=mysqli_fetch_assoc($result)){
        echo "<br><br><h4>".$rows['name']."</h4>";
        echo '<a href="'.$rows['path'].'">';
        echo '<img src="'.$rows['path'].'" width="800"/> </a>';
      }
    ?>


    <br><br>
    </div>



</body>
</html>