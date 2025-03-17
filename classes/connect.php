<?php 
if (!defined('ROOT')) {
    define("ROOT", "http://localhost/mybook");
}


class Database
{

	// private $host = "localhost";
	private $host = "127.0.0.1";

	private $username = "root";
	// private $password = "";
	private $password = "your_password";

	private $db = "mybook_db";
	
	function connect()
	{

		// $connection = mysqli_connect($this->host,$this->username,$this->password,$this->db);
		$connection = mysqli_connect($this->host, $this->username, $this->password, $this->db, 3307);

		return $connection;
	}

	function read($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn,$query);

		if(!$result)
		{
			return false;
		}
		else
		{
			$data = false;
			while($row = mysqli_fetch_assoc($result))
			{

				$data[] = $row;

			}

			return $data;
		}
	}

	function save($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn,$query);

		if(!$result)
		{
			return false;
		}else
		{
			return true;
		}
	}

}
