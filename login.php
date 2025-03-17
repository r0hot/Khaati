<?php 

session_start();

	include("classes/connect.php");
	include("classes/login.php");
 
	$email = "";
	$password = "";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{


		$login = new Login();
		$result = $login->evaluate($_POST);
		
		if($result != "")
		{

			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{

			header("Location: ".ROOT."profile");
			die;
		}
 

		$email = $_POST['email'];
		$password = $_POST['password'];
		

	}


	

?>

<html> 

	<head>
		
		<title>Khaati | Log in</title>
	</head>

	<style>
		
		.background {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: url('images/back.webp') no-repeat center center fixed;
			background-size: cover;
			filter: blur(5px); /* Adjust blur intensity */
			z-index: -1; /* Keeps it behind other content */
		}
		#bar{
			height:100px;
			background-color: rgb(59,89,152);
			color: #d9dfeb;
			padding: 4px;
		}

		#signup_button{

			background-color: #42b72a;
			width: 70px;
			text-align: center;
			padding:4px;
			border-radius: 4px;
			float:right;
		}

		#bar2{

			background-color: white;
			width:800px;
			margin:auto;
			margin-top: 50px;
			padding:10px;
			padding-top: 50px;
			text-align: center;
			font-weight: bold;

		}

		#text{

			height: 40px;
			width: 300px;
			border-radius: 4px;
			border:solid 1px #ccc;
			padding: 4px;
			font-size: 14px;
		}

		#button{

			width: 300px;
			height: 40px;
			border-radius: 4px;
			font-weight: bold;
			border:none;
			background-color: rgb(59,89,152);
			color: white;
		}

	</style>
<div class = "background">

</div>
	<body style="font-family: tahoma;background-color: #e9ebee;">
		
		<div id="bar">

			<div style="font-size: 40px;">Khaati</div>
			<a href="<?=ROOT?>index">
			<div id="signup_button">Signup</div>
			</a>
		</div>

		<div id="bar2">
			
			<form method="post">
				Log in to Khaati<br><br>

				<input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email"><br><br>
				<input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br><br>

				<input type="submit" id="button" value="Log in">
				<br><br><br>

			</form>
		</div>
		<br>
		<footer style="background: #2c3e50; color: #ffffff; padding: 20px; text-align: center;">
    <h2 style="margin-bottom: 10px;">Khaati – Authentic Flavors, Real Stories</h2>
    <p style="margin-bottom: 15px;">📍 Bringing You the Essence of Tradition & Culture</p>
    
    <nav>
        <p><strong>🔗 Quick Links:</strong></p>
        <ul style="list-style: none; padding: 0;">
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #f1c40f; text-decoration: none;">Home</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #f1c40f; text-decoration: none;">About Us</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #f1c40f; text-decoration: none;">Recipes</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #f1c40f; text-decoration: none;">Blog</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #f1c40f; text-decoration: none;">Shop</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #f1c40f; text-decoration: none;">Contact</a></li>
        </ul>
    </nav>
    
    <div class="contact-info" style="margin-top: 15px;">
        <p><strong>📩 Get in Touch:</strong></p>
        <p>Email: <a href="mailto:Khaati@contact.com" style="color: #f1c40f; text-decoration: none;">Khaati@contact.com</a></p>
        <p>Call Us: <a href="tel:+91XXXXXXXXXX" style="color: #f1c40f; text-decoration: none;">+91 XXXXXXXXXX</a></p>
    </div>
    
    <div class="social-links" style="margin-top: 15px;">
        <p><strong>🌍 Follow Us for Updates & Exclusive Content:</strong></p>
        <a href="#" style="color: #f1c40f; text-decoration: none; margin: 0 5px;">📸 Instagram</a> |
        <a href="#" style="color: #f1c40f; text-decoration: none; margin: 0 5px;">👍 Facebook</a> |
        <a href="#" style="color: #f1c40f; text-decoration: none; margin: 0 5px;">🐦 Twitter/X</a> |
        <a href="#" style="color: #f1c40f; text-decoration: none; margin: 0 5px;">🎥 YouTube</a>
    </div>
    
    <div class="newsletter" style="margin-top: 20px;">
        <p><strong>💌 Subscribe to Our Newsletter for Recipes, Tips & Offers!</strong></p>
        <form action="#" method="post" style="display: inline-block; margin-top: 10px;">
            <input type="email" name="email" placeholder="Enter your email" required style="padding: 8px; border: none; border-radius: 5px; margin-right: 5px;">
            <button type="submit" style="background: #f1c40f; color: #2c3e50; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer;">Subscribe</button>
        </form>
    </div>
    
    <p style="margin-top: 20px; font-size: 14px;">&copy; 2025 Khaati. All Rights Reserved. | <a href="#" style="color: #f1c40f; text-decoration: none;">Privacy Policy</a> | <a href="#" style="color: #f1c40f; text-decoration: none;">Terms & Conditions</a></p>
</footer>
	</body>


</html>