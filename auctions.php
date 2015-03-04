<?php
	
	/*
		* @author     Ziad El-Wali <Ziadelwali@gmail.com>
	*/
	
	include 'secure/db_connect.php';
	include 'secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.
	
	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
	    include 'header.php';
	?>
	
	<div id="section">
		<table style="width:100%">
			<tr>
				<td>
					<h2>old vase</h2>
					<a href="current_auction.php"><img src="img/vase3.jpg" alt="The picture could not be found" style="width:304px;height:228px"></a>
					<p>
						The vase's is very old. Hurry up to bit.
					</p>
				</td>
				<td>
					<h2>Nice vase</h2>
					<img src="img/vase4.jpg" alt="The picture could not be found" style="width:304px;height:228px">
					<p>
						Thoose two vase's belong's to each other. Therefore you can only bit at both of them.
					</p>
				</td>
				<td>
					<h2>ugly vase</h2>
					<img src="img/vase2.jpg" alt="The picture could not be found" style="width:304px;height:228px">
					<p>
						The vase's is very cheap. 
					</p>
				</td>
				<td>
					<h2>beatyfull vase</h2>
					<img src="img/vase1.jpg" alt="The picture could not be found" style="width:304px;height:228px">
					<p>
						The vase is a seldon old one and nearlyun broken.
						<tr>
							<td>
								
								
								<h2>cheap vase</h2>
								<a href="logIn.html"><img src="img/vase5.jpg" alt="The picture could not be found" style="width:304px;height:228px"></a>
								<p>
									The vase's is very cheap. Specially if you hurry up.
								</p>
							</td>
							<td>
								<h2>Nice vase</h2>
								<img src="img/vase6.jpg" alt="The picture could not be found" style="width:304px;height:228px">
								<p>
									The picture shows the vase
								</p>
							</td>
							<td>
								<h2>fine vase</h2>
								<img src="img/vase7.jpg" alt="The picture could not be found" style="width:304px;height:228px">
								<p>
									The vase's is to flowers.
								</p>
							</td>
							<td>
								<h2>Very nice vase</h2>
								<img src="img/vase8.jpg" alt="The picture could not be found" style="width:304px;height:228px">
								<p>
									No description on this vase. I mean, It's a vase.
									<tr>
										<td>
											<h2>The vase</h2>
											<a href="logIn.html"><img src="img/vase9.jpg" alt="The picture could not be found" style="width:304px;height:228px"></a>
											<p>
												Very beatyfull.
											</p>
										</td>
										<td>
											<h2>Nice vase</h2>
											<img src="img/vase10.jpg" alt="The picture could not be found" style="width:304px;height:228px">
											<p>
												Thoose two vase's belong's to each other. Therefore you can only bit at both of them.
											</p>
										</td>
										<td>
											<h2>ugly vase</h2>
											<img src="img/vase12.jpg" alt="The picture could not be found" style="width:304px;height:228px">
											<p>
												The vase's is very old. Hurry up to bit.
											</p>
										</td>
										<td>
											<h2>Nice vase</h2>
											<img src="img/vase11.jpg" alt="The picture could not be found" style="width:304px;height:228px">
											<p>
												Thoose two vase's belong's to each other. Therefore you can only bit at both of them.
											</p>
										</td>
									</table>
									</div>
									
							
							
							
							
							
							<?php
								include 'footer.php';
							}
							else if ($_SESSION['status'] == 1)
							{
								header("Location: index.php?logError=5");
								// Destroy session
								session_destroy();
								exit;
							}
							else
							{
								echo 'You are not authorized to access this page, please login. <br/>';
							}
?>