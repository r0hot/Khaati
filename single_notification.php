<?php 

	$actor = $User->get_user($notif_row['userid']);
	$owner = $User->get_user($notif_row['content_owner']);
	$id = esc($_SESSION['mybook_userid']);

	$link = "";

	if($notif_row['content_type'] == "post"){
		$link = ROOT . "single_post/" . $notif_row['contentid'] . "/" . $notif_row['id'];
	} elseif($notif_row['content_type'] == "profile"){
		$link = ROOT . "profile/" . $notif_row['userid'] . "/" . $notif_row['id'];
	} elseif($notif_row['content_type'] == "comment"){
		$link = ROOT . "single_post/" . $notif_row['contentid'] . "/" . $notif_row['id'];
	} elseif($notif_row['content_type'] == "group" && $notif_row['activity'] == "role"){
		$link = ROOT . "group/" . $notif_row['contentid'] . "/members/" . $notif_row['id'];
	} elseif($notif_row['content_type'] == "group" && $notif_row['activity'] == "invite"){
		$link = ROOT . "group/" . $notif_row['contentid'] . "/invited/" . $notif_row['id'];
	}

	//check if the notification was seen
	$query = "SELECT * FROM notification_seen WHERE userid = '$id' AND notification_id = '{$notif_row['id']}' LIMIT 1";
	$seen = $DB->read($query);

	$color = is_array($seen) ? "#eee" : "#dfcccc";
?>

<a href="<?php echo $link ?>" style="text-decoration: none;">
	<div id="notification" style="background-color: <?= $color ?>">

		<?php
			if(is_array($actor) && is_array($owner)){

				$image = "images/user_male.jpg";
				if($actor['gender'] == "Female") {
					$image = "images/user_female.jpg";
				}

				if(file_exists($actor['profile_image'])) {
					$image = $image_class->get_thumb_profile($actor['profile_image']);
				}

				echo "<img src='".ROOT."$image' style='width:36px;margin:4px;float:left;' />";

				echo ($actor['userid'] != $id) ? $actor['first_name'] . " " . $actor['last_name'] : "You ";

				$activities = [
					"like" => " liked ",
					"follow" => " followed ",
					"comment" => " commented ",
					"tag" => " tagged ",
					"role" => " changed your access to ",
					"invite" => " invited you to "
				];

				echo $activities[$notif_row['activity']] ?? "";

				if($owner['userid'] != $id && $notif_row['activity'] != "tag"){
					echo $owner['first_name'] . " " . $owner['last_name'] . "'s ";
				} elseif($notif_row['activity'] == "tag"){
					echo " you in a ";
				} else {
					echo ($notif_row['activity'] == "invite" || $notif_row['activity'] == "role") ? " a " : " your ";
				}

				$content_row = $Post->get_one_post($notif_row['contentid']);

				if (is_array($content_row)) {
					$post_text = isset($content_row['post']) ? htmlspecialchars(substr($content_row['post'], 0, 50)) : "Content not available";
				} else {
					$post_text = "Content not available";
				}

				if($notif_row['content_type'] == "post"){
					if(!empty($content_row['has_image']) && file_exists($content_row['image'])) {
						$post_image = ROOT . $image_class->get_thumb_post($content_row['image']);
						echo "image <img src='$post_image' style='width:40px;float:right;' />";
					} else {
						echo $notif_row['content_type'];
						echo "<span style='float:right;font-size:11px;color:#888;display:inline-block;margin-right:10px;'>$post_text</span>";
					}
				} else {
					echo $notif_row['content_type'];
					echo "<span style='float:right;font-size:11px;color:#888;display:inline-block;margin-right:10px;'>$post_text</span>";
				}

				$date = date("jS M Y H:i:s a", strtotime($notif_row['date']));
				echo "<br><span style='font-size:11px;color:#888;display:inline-block;margin-right:10px;'>$date</span>";
			}
		?>
	</div>
</a>
