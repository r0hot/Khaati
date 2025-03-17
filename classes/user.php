<?php 

class User
{

	public function get_data($id)
	{

		$query = "select * from users where userid = '$id' limit 1";
		
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{

			$row = $result[0];
			return $row;
		}else
		{
			return false;
		}
	}

	public function get_user($id)
	{

		$query = "select * from users where userid = '$id' limit 1";
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result[0];
		}else
		{

			return false;
		}
	}

	public function get_friends($id)
	{

		$query = "select * from users where userid != '$id' ";
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;
		}else
		{

			return false;
		}
	}


	public function get_following($id, $type) {
		$DB = new Database();
		$type = addslashes($type);
	
		if (is_numeric($id)) {
			// Get following details
			$sql = "SELECT following FROM likes WHERE type='$type' AND contentid = '$id' LIMIT 1";
			$result = $DB->read($sql);
	
			if (is_array($result) && isset($result[0]['following'])) {
				$following = json_decode($result[0]['following'], true);
	
				if (is_array($following)) {
					return $following;
				}
			}
		}
	
		return []; // Return an empty array instead of false to prevent errors
	}
	

	// public function follow_user($id,$type,$mybook_userid){

	// 		if($id == $mybook_userid && $type == 'user'){
	// 			return;
	// 		}

 	// 		$DB = new Database();
 			
	// 		//save likes details
	// 		$sql = "select following from likes where type='$type' && contentid = '$mybook_userid' limit 1";
	// 		$result = $DB->read($sql);
	// 		if(is_array($result)){

	// 			$likes = json_decode($result[0]['following'],true);

	// 			$user_ids = array_column($likes, "userid");
 
	// 			if(!in_array($id, $user_ids)){

	// 				$arr["userid"] = $id;
	// 				$arr["date"] = date("Y-m-d H:i:s");

	// 				$likes[] = $arr;

	// 				$likes_string = json_encode($likes);
	// 				$sql = "update likes set following = '$likes_string' where type='$type' && contentid = '$mybook_userid' limit 1";
	// 				$DB->save($sql);

	// 				$user = new User();
	// 				$single_post = $user->get_user($id);

	// 				//add notification
	// 				add_notification($_SESSION['mybook_userid'],"follow",$single_post);
	// 			}else{

	// 				$key = array_search($id, $user_ids);
	// 				unset($likes[$key]);

	// 				$likes_string = json_encode($likes);
	// 				$sql = "update likes set following = '$likes_string' where type='$type' && contentid = '$mybook_userid' limit 1";
	// 				$DB->save($sql);
 
	// 			}
				

	// 		}else{

	// 			$arr["userid"] = $id;
	// 			$arr["date"] = date("Y-m-d H:i:s");

	// 			$arr2[] = $arr;

	// 			$following = json_encode($arr2);
	// 			$sql = "insert into likes (type,contentid,following) values ('$type','$mybook_userid','$following')";
	// 			$DB->save($sql);
 				
 	// 			$user = new User();
	// 			$single_post = $user->get_user($id);

	// 			//add notification
	// 			add_notification($_SESSION['mybook_userid'],"follow",$single_post);
	// 		}

	// }
	// public function follow_user($id, $type, $mybook_userid) {
	// 	if ($id == $mybook_userid && $type == 'user') {
	// 		return;
	// 	}
	
	// 	$DB = new Database();
	
	// 	// Fetch following details
	// 	$sql = "SELECT following FROM likes WHERE type='$type' AND contentid = '$mybook_userid' LIMIT 1";
	// 	$result = $DB->read($sql);
	
	// 	// Initialize following array
	// 	$likes = [];
	// 	$user_ids = [];
	
	// 	if (is_array($result) && isset($result[0]['following'])) {
	// 		$likes = json_decode($result[0]['following'], true);
	
	// 		if (is_array($likes)) {
	// 			$user_ids = array_column($likes, "userid");
	// 		}
	// 	}
	
	// 	if (!in_array($id, $user_ids)) {
	// 		// Add new follow
	// 		$arr = [
	// 			"userid" => $id,
	// 			"date" => date("Y-m-d H:i:s")
	// 		];
	// 		$likes[] = $arr;
	// 	} else {
	// 		// Unfollow if already following
	// 		$key = array_search($id, $user_ids);
	// 		unset($likes[$key]);
	// 	}
	
	// 	// Update database
	// 	$likes_string = json_encode(array_values($likes));
		
	// 	if (is_array($result) && isset($result[0]['following'])) {
	// 		$sql = "UPDATE likes SET following = '$likes_string' WHERE type='$type' AND contentid = '$mybook_userid' LIMIT 1";
	// 	} else {
	// 		$sql = "INSERT INTO likes (type, contentid, following) VALUES ('$type', '$mybook_userid', '$likes_string')";
	// 	}
	
	// 	$DB->save($sql);
	
	// 	// Add notification
	// 	$user = new User();
	// 	$single_post = $user->get_user($id);
	// 	add_notification($_SESSION['mybook_userid'], "follow", $single_post);
	// }

	public function follow_user($id, $type, $mybook_userid) {
		if ($id == $mybook_userid && $type == 'user') {
			return;
		}
	
		$DB = new Database();
	
		// Fetch following details
		$sql = "SELECT following FROM likes WHERE type='$type' AND contentid = '$mybook_userid' LIMIT 1";
		$result = $DB->read($sql);
	
		// Initialize following array
		$likes = [];
		$user_ids = [];
	
		if (is_array($result) && isset($result[0]['following'])) {
			$likes = json_decode($result[0]['following'], true);
	
			if (is_array($likes)) {
				$user_ids = array_column($likes, "userid");
			}
		}
	
		$is_following = in_array($id, $user_ids);
		
		if (!$is_following) {
			// Add new follow
			$arr = [
				"userid" => $id,
				"date" => date("Y-m-d H:i:s")
			];
			$likes[] = $arr;
	
			// Send notification only when following, NOT when unfollowing
			$user = new User();
			$single_post = $user->get_user($id);
			add_notification($_SESSION['mybook_userid'], "follow", $single_post);
		} else {
			// Unfollow if already following
			$key = array_search($id, $user_ids);
			unset($likes[$key]);
		}
	
		// Update database
		$likes_string = json_encode(array_values($likes));
	
		if (is_array($result) && isset($result[0]['following'])) {
			$sql = "UPDATE likes SET following = '$likes_string' WHERE type='$type' AND contentid = '$mybook_userid' LIMIT 1";
		} else {
			$sql = "INSERT INTO likes (type, contentid, following) VALUES ('$type', '$mybook_userid', '$likes_string')";
		}
	
		$DB->save($sql);
	}
	
	
	}