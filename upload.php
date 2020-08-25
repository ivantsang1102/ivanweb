<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload</title>
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
	<br><br>

    <div class="container">
    	<form action="upload.php" method="post" enctype="multipart/form-data">
    	  <p><b>Adding photos to Month.php</b></p>
    	  <p>Month: <input type="text" name="img_name"> </p>
    	  <p>
		      Select image to upload:
			  <input type="file" name="fileToUpload" id="fileToUpload">
			  <input type="submit" value="Upload Image" name="submit">
		  </p>
		</form>

    </div>


    
	<?php

		if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
	    {
	        func();
	    }
	    function func()
	    {
	        $img_name = $_POST['img_name'];   
            $target_dir = "website/images/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			
			if(isset($_POST["submit"])) {
			  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			  if($check !== false) {
			    echo "File is an image - " . $check["mime"] . ".";
			    $uploadOk = 1;
			  } else {
			    echo "File is not an image.";
			    $uploadOk = 0;
			  }
			}

			// Check if file already exists
			if (file_exists($target_file)) {
			  echo "Sorry, file already exists.";
			  $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			  $uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			  echo "Sorry, your file was not uploaded.";
			
			// if everything is ok, try to upload file
			} else {
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			    $query = 'insert into image (name, path) values ("'.$img_name.'", "'.$target_file.'");';
				$con = mysqli_connect('localhost','tcf','134889','hsi');
			    mysqli_query($con, $query);

			  } else {
			    echo "Sorry, there was an error uploading your file.";
			  }
			}

			
		    $_POST = array();
		}
	?>


</body>
</html>