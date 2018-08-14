<?php
require 'class/Db.php';
$database = new Database();

if(isset($_POST["action"]))
{
	if($_POST["action"] == "Load")
	{
		echo $database->get_data_in_table("SELECT * FROM flower");
	}
	if($_POST["action"] == "Insert")
	{
		$name = mysqli_real_escape_string($database->connect, $_POST["name"]);
		$color = mysqli_real_escape_string($database->connect, $_POST["color"]);
		$pic = $database->upload_file($_FILES["user_pic"]);
		$query = "INSERT INTO flower(name, color, pic) VALUES ('".$name."', '".$color."', '".$pic."')";
		$database->execute_query($query);
		echo 'DATA Inserted';
	}
	if($_POST["action"] == "Fetch Single Data")
	{
		$output = '';
		$query = "SELECT * FROM flower WHERE id = '".$_POST["user_id"]."'";
		$result = $database->execute_query($query);
		while($row = mysqli_fetch_array($result))
		{
			$output["name"] = $row["name"];
			$output["color"] = $row["color"];
			$output["user_pic"] = $row["pic"];
			$output["pic"] = '<img src="upload/'.$row['pic'].'" class="img-thumbnail" width="50" height="35" />';
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "Edit")
	{
		$pic = '';
		if($_FILES["user_pic"]["name"] != '')
		{
			$pic = $database->upload_file($_FILES["user_pic"]);
		}
		else
		{
			$pic = $_POST["hidden_user_pic"];
		}
		$name = mysqli_real_escape_string($database->connect, $_POST["name"]);
		$color = mysqli_real_escape_string($database->connect, $_POST["color"]);
		$query = "UPDATE flower SET name = '".$name."', color = '".$color."', pic = '".$pic."' WHERE id = '".$_POST["user_id"]."'";
		$database->execute_query($query);
		echo 'Data Updated';
	}
}


?>