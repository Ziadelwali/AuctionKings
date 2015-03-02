<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Ziad El-Wali -- Software developer">
        <meta name="description" content="Ziad El-Wali's website">
        <title>Auction Kings Website</title>
		<script src="secure/forms.js"></script>
		<!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		
        <!-- Responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
		
        <!--Custom Styles-->
        <link href="css/style.css" rel="stylesheet">
		
		<!--Recaptcha script from google
			<script src='https://www.google.com/recaptcha/api.js'></script>
		-->
	</head>
	
    <body>
        <div class="container-fluid" id="mainwrapper">
            <div class="container-fluid" id="content">
				<h1>Auction Kings Website</h1></br>
				<p>Login Form</p>
				
				<!--LoginForm-->              
                <div class="row-fluid">
                    <div class="span4 offset3">
						
						<form action="secure/process_login.php" method="post" name="login_form" class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="inputEmail">Email</label>
								<div class="controls">
									<input type="email" id="email" name="loginEmail" placeholder="Email">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Password</label>
								<div class="controls">
									<input type="password" name="loginPassword" id="password" placeholder="Password">
									<input type="hidden" name="p">
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<button type="submit" class="btn" onclick="checkAndSubmit(this.form, this.form.loginPassword);">Sign in here</button><br/>
									<!-- if login failed show this -->
									<?php if(isset($_GET['logError']))
										{
											switch ($_GET['logError']) 
											{
												case 1:
												echo "Login failed!";
												break;
												
												case 2:
												echo "Empty password!";
												break;
												
												case 3:
												echo "Email is required!";
												break;
												
												case 4:
												echo "Invalid email format!";
												break;
												
												case 5:
												echo "Your profile has been deleted or banned! <br/> Contact admin.";
												break;

                                                case 6:
												echo "Your profile has been successfully deleted by you!";
												break;
												
												default:
												echo "Unknown error!";
											}
										}?>   
								</div>
							</div>
						</form>
					</div><!--/span4-->
				</div><!--/row-fluid-->
				           
				<!--THE REGISTRATION FORM-->
				
				<p>Registration Form</p>
				<div class="row-fluid">
					<div class="span4 offset3">
						
						<form action="secure/sec_reg.php" method="post" name="registration_form" class="form-horizontal">
							
							<div class="control-group">
								<label class="control-label" for="inputUser">Username</label>
								<div class="controls">
									<input type="text" id="username" name="regUsername" placeholder="Username">
								</div></br>
								<div class="control-group">
									<label class="control-label" for="inputEmail">Email</label>
									<div class="controls">
										<input type="email" id="email" name="regEmail" placeholder="Email">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Password</label>
									<div class="controls">
										<input type="password" name="regPassword" id="password" placeholder="Password">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="retypePassword">Retype password</label>
									<div class="controls">
										<input type="password" name="regPassword2" id="password2" placeholder="Retype Password">
										<input type="hidden" name="p">
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<input type="submit" class="btn" value="Register here" onclick="return checkAndSubmit2(this.form, this.form.regPassword, this.form.regPassword2);"></input>
										
										<!-- If registration successfull show everything ok info -->
										<? if(isset($_GET['success'])) {?>
											<p>You have sucessfully registered </br>and can now log in at the login form above!</p>
										<? }?>
										<!-- if registration error show this -->
										<p>
											<?php 
												if(isset($_GET['regError'])) 
												{
													switch ($_GET['regError']) 
													{
														case 1:
														echo "The registration did not go right somehow!";
														break;
														
														case 2:
														echo "Email or username already exists!";
														break;
														
														case 3:
														echo "Database connection failed!";
														break;
														
														case 4:
														echo "Name is required!";
														break;
														
														case 5:
														echo "Only letters and white space allowed!";
														break;
														
														case 6:
														echo "Email is required";
														break;
														
														case 7:
														echo "Invalid email format";
														break;
														
														case 8:
														echo "password is required";
														break;
														
														default:
														echo "Unknown error!";
													}
												} 
											?>
										</p>										
									</div>
								</div>
								<!-- ReCaptcha html code 
									<form method="post" action="verify.php">
									<?php
										/*
											require_once('recaptchalib.php');
											$publickey = "6LcNXP8SAAAAAPxx36tf3ht_zkI1G96vlAb01YC3"; // you got this from the signup page
											echo recaptcha_get_html($publickey);
										*/
									?>
									<input type="submit" />
									<div class="g-recaptcha" data-sitekey="6LcNXP8SAAAAAPxx36tf3ht_zkI1G96vlAb01YC3"></div>
									</form><br>
								End of ReCaptcha code -->
							</form>
						</div>
					</div>
				</div> <!-- End of Registration div -->
			</div>
		</div>
		
		<!--Scripts-->
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="secure/sha512.js"></script>
		
		
	</body>
</html>																																																									