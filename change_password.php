<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sale Perchase System</title>
	
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
	<link rel="stylesheet" href="css/style.css">
	
	<!-- Optimize for mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- jQuery & JS files -->
	<?php include_once("tpl/common_js.php"); ?>
	<script src="js/script.js"></script>  
</head>
<body>

	<!-- TOP BAR -->
	<?php include_once("tpl/top_bar.php"); ?>
	<!-- end top-bar -->
	
	
	
		<!-- HEADER -->
	<div id="header-with-tabs">
		
		<div class="page-full-width cf">
	
			<ul id="tabs" class="fl">
				<li><a href="dashboard.php" class="active-tab dashboard-tab">Dashboard</a></li>
			<!--	<li><a href="view_sales.php" class="sales-tab">Sales</a></li>
				<li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
				<li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
				<li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
				<li><a href="view_product.php" class=" stock-tab">Stocks / Products</a></li>
				<li><a href="view_payments.php" class="payment-tab">Payments / Outstandings</a></li>
				<li><a href="view_report.php" class="report-tab">Reports</a></li> -->
			</ul> <!-- end tabs -->
			
			<!-- Change this image to your own company's logo -->
			<!-- The logo will automatically be resized to 30px height. -->
			<a href="#" id="company-branding-small" class="fr"><img src="upload/logos.jpg" /></a>
			
		</div> <!-- end full-width -->	

	</div> <!-- end header -->
	
	
	
	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="page-full-width cf">

			<div class="side-menu fl">
				
			<!--	<h3>Quick Links</h3>
				<ul>
					<li><a href="add_sales.php">Add Sales</a></li>
					<li><a href="add_purchase.php">Add Purchase</a></li>
					<li><a href="add_supplier.php">Add Supplier</a></li>
					<li><a href="add_customer.php">Add Customer</a></li>
					<li><a href="view_report.php">Report</a></li> -->
				</ul>
				
			</div> <!-- end side-menu -->
			
			<div class="side-content fr">
			
				<div class="content-module">
				
					<div class="content-module-heading cf">
					
						<h3 class="fl">Statistics</h3>
						<span class="fr expand-collapse-text">Click to collapse</span>
						<span class="fr expand-collapse-text initial-expand">Click to expand</span>
					
					</div> <!-- end content-module-heading -->
					
						<div class="content-module-main cf">
				
				<?php
                             if (isset($_POST['old_pass']) && isset($_POST['new_pass']) && isset($_POST['confirm_pass'])) {
								$username = $_SESSION['username'];
								$old_pass = $_POST['old_pass'];
								$count = $db->countOf("stock_user", "username='$username' and password='$old_pass'");
								if ($count == 0) {
									echo "<br><font color=red size=6px >Old Password is wrong!</font>";
								} else {
									if (trim($_POST['new_pass']) == trim($_POST['confirm_pass'])) {
										$new_pass = $_POST['confirm_pass'];
										$hashedPassword = password_hash($new_pass, PASSWORD_DEFAULT); // Encrypt the new password
										$db->query("UPDATE stock_user SET password='$hashedPassword' WHERE username='$username'");
										echo "<br><font color=green size=6px >Password is successfully updated!</font>";
									} else {
										echo "<br><font color=red size=6px >Confirm password is wrong!</font>";
									}
								}
							}
							
							
								

									// Retrieve the entered username and password
									
									// Perform further validation and database checks
								
								
									// Retrieve the hashed password from the database based on the entered username
									// Perform database checks and retrieve the stored hashed password
									
								
                                ?>	
				 <form action="" method="post">
				<table style="width:600px; margin-left:50px; float:left;" border="0" cellspacing="0" cellpadding="0">
                                   
                                    <tr>
                                        <td>Old Password</td><td><input type="password" name="old_pass"></td></tr>
                                  <tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr>
                                      <td>New Password</td><td><input type="password" name="new_pass"  ></td></tr>
                                      <tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr>
                                      <td>Confirm Password</td><td><input type="password" name="confirm_pass"></td>
				  </tr>
                                  <tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr> <tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr></tr>
                                  <tr><td>
                        <input class="button round blue image-right ic-add text-upper" type="submit" name="Submit" name="change_pass" value="Save">
                     </td><td>			
                     <input class="button round red   text-upper"  type="reset" name="Reset" value="Reset"> </td></tr>
				
				</table>
				</form>		<!--<ul class="temporary-button-showcase">
							<li><a href="#" class="button round blue image-right ic-add text-upper">Add</a></li>
							<li><a href="#" class="button round blue image-right ic-edit text-upper">Edit</a></li>
							<li><a href="#" class="button round blue image-right ic-delete text-upper">Delete</a></li>
							<li><a href="#" class="button round blue image-right ic-download text-upper">Download</a></li>
							<li><a href="#" class="button round blue image-right ic-upload text-upper">Upload</a></li>
							<li><a href="#" class="button round blue image-right ic-favorite text-upper">Favorite</a></li>
							<li><a href="#" class="button round blue image-right ic-print text-upper">Print</a></li>
							<li><a href="#" class="button round blue image-right ic-refresh text-upper">Refresh</a></li>
							<li><a href="#" class="button round blue image-right ic-search text-upper">Search</a></li>
						</ul>-->
				
					</div> <!-- end content-module-main -->
							
				
				</div> <!-- end content-module -->
				
				
		
		</div> <!-- end full-width -->
			
                </div>
            </div>

	
	<!-- FOOTER -->
	<div id="footer">

		<p> &copy;SsekirandaEdgarWatson 2023</p>

	
	</div> <!-- end footer -->

</body>
</html>