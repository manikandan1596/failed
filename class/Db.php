<?php

	class Database
	{
		public $connect;
		private $host = 'localhost';
		private $username = 'root';
		private $password = '';
		private $database = 'new';
		
		function __construct()
		{
			$this->database_connect();
		}		
		
		public function database_connect()
		{	
			$this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
		}
		
		public function execute_query($query)
		{
			return mysqli_query($this->connect, $query);
		}
		public function get_data_in_table($query)
		{
			$output = '';
			$result = $this->execute_query($query);
			$output = '
				<table class="table table-bordered table-striped">
					<tr>
						<th width="10%">ID</th>
						<th width="25%">NAME</th>
						<th width="15%">COLOR</th>
						<th width="30%">PIC</th>
						<th width="10%">UPDATE</th>
						<th width="10%">DELETE</th>
					</tr>
			';
			while($row = mysqli_fetch_object($result))
			{
				$output .= '
					<tr>
						<td>'.$row->id.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->color.'</td>
						<td><img src="upload/'.$row->pic.'" class="img-thumbnail" width="50" height="35" /></td>
						<td><button type="button" name="update" id="'.$row->id.'" class="btn btn-success btn-xs update">UPDATE</button></td>
						<td><button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete">DELETE</button></td>
					</tr>
				';
			}
			$output .= '</table>';
			return $output;
			
		}
		function upload_file($file)
		{
			if(isset($file))
			{
				$extension = explode('.', $file["name"]);
				$new_name = rand() . '.' . $extension[1];
				$destination = './upload/' . $new_name;
				move_uploaded_file($file['tmp_name'], $destination);
				return $new_name;
			}
		}
	
	}
	?>