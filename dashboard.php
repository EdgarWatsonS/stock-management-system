<?php
 
 include_once("init.php"); 

?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Admin - Dashboard</title>
	
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
	<?php include_once("analyticstracking.php") ?>
	
		<!-- HEADER -->
	<div id="header-with-tabs">
		
		<div class="page-full-width cf">
	
			<ul id="tabs" class="fl">
				<li><a href="dashboard.php" class="active-tab dashboard-tab">Dashboard</a></li>
				<li><a href="view_product.php" class=" stock-tab">Stocks / Products</a></li>
				<li><a href="stock_added_report.php" class="report-tab">Stock In Report</a></li>
				<li><a href="stock_out_report.php" class="report-tab">Stock Out Report</a></li>
			<!--	<li><a href="view_report.php" class="active-tab report-tab">Reports</a></li> -->
			<!--	<li><a href="view_report.php" class="report-tab">Reports</a></li> -->
			</ul> <!-- end tabs -->
			
			<!-- Change this image to your own company's logo -->
			<!-- The logo will automatically be resized to 30px height. -->
			<?php $line = $db->queryUniqueObject("SELECT * FROM stock_details ");
			     $_SESSION['logo']=$line->log; 
			 ?>
          <a href="#" id="company-branding-small" class="fr"><img src="upload/logos.jpg" /></a>
			
		</div> <!-- end full-width -->	

	</div> <!-- end header -->
	
	
	
	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="page-full-width cf">

			<div class="side-menu fl">
				
				<h3>Quick Links</h3>
				<ul>
					
					<li><a href="view_product.php">View Stock</a></li> 
				    <li><a href="add_stock.php">Add Stock</a></li>
					<li><a href="stock_added_report.php">Stock Added Report</a></li>
					<li><a href="stock_out_report.php">Stock out Report</a></li> 
				</ul>
                                
                                 
			</div> <!-- end side-menu -->
                        
			<div class="side-content fr">
			
				<div class="content-module">
				
					<div class="content-module-heading cf">
					
				<!--		<h3 class="fl">Statistics</h3>
						<span class="fr expand-collapse-text">Click to collapse</span>
						<span class="fr expand-collapse-text initial-expand">Click to expand</span> -->
					
					</div> <!-- end content-module-heading -->
					
						<div class="content-module-main cf">
				
							
						<!--		<table style="width:350px; float:left;" border="0" cellpadding="0" cellspacing="0">
								  <tr>
									<td width="250" align="left">&nbsp;</td>
									<td width="150" align="left">&nbsp;</td>
								  </tr>
								  <tr>
									<td align="left">Total Number of Products</td>
									<td align="left"><?php echo  $count = $db->countOfAll("stock_details");?>&nbsp;</td>
								  </tr>
								  <tr>
									<td align="left">&nbsp;</td>
									<td align="left">&nbsp;</td>
								  </tr>
								  <tr>
									<td align="left">Total Sales Transactions </td>
									<td align="left"><?php echo  $count = $db->countOfAll("stock_sales");?></td>
								  </tr>
								  <tr>
									<td align="left">&nbsp;</td>
									<td align="left">&nbsp;</td>
								  </tr>
								  <tr>
									<td align="left">Total number of Suppliers </td>
									<td align="left"><?php echo $count = $db->countOfAll("supplier_details");?></td>
								  </tr>
								  <tr>
									<td align="left">&nbsp;</td>
									<td align="left">&nbsp;</td>
								  </tr>
								  <tr>
									<td align="left">Total Number of Customers </td>
									<td align="left"><?php echo $count = $db->countOfAll("customer_details");?></td>
								  </tr>   
								  <tr>
									<td align="left">&nbsp;</td>
									<td align="left">&nbsp;</td>
								  </tr>
								  <tr>
									<td align="left">&nbsp;</td>
									<td align="left">&nbsp;</td>
								  </tr>
						  </table> -->
				
			
						<!--<ul class="temporary-button-showcase">
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
                
                <div class="content-module">
                
                <div class="content-module-heading cf">
					
						<h3 class="fl">Stock Information</h3>
						<span class="fr expand-collapse-text">Click to collapse</span>
						<span class="fr expand-collapse-text initial-expand">Click to expand</span>
					
					</div>
					<div class="content-module-main cf">
						<table>
							<form action="" method="post" name="search">
								&nbsp;&nbsp;
								&nbsp;&nbsp;
								&nbsp;&nbsp;
								<input name="searchtxt" type="text" class="round my_text_box" placeholder="Search" style="margin-left: 200px"> 
								&nbsp;&nbsp;
								<input name="Search" type="submit" class="my_button round blue text-upper" value="Search">
							</form> 

							<?php 
								$SQL = "SELECT * FROM stock_details";
								if (isset($_POST['Search']) && trim($_POST['searchtxt']) != "") {
									$searchTerm = $_POST['searchtxt'];
									$SQL = "SELECT * FROM stock_details WHERE stock_name LIKE '%$searchTerm%' OR category LIKE '%$searchTerm%' OR stock_id LIKE '%$searchTerm%'";
									// Rest of your code...
								}

								$result = mysqli_query($conn, $SQL);
								
							?>	
							
							<tr>
								<td>&nbsp;</td>
								<th>Storage Space</th>
								<th>Product Category</th>
								<th>Product Name</th>
								<th>Available Quantity</th>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
										
							<?php	
							while($row = mysqli_fetch_array($result)) 
							{
							?> 
								<tr>
									<td>&nbsp;</td>
									<td>
										<?php 
											$ss = $db->queryUniqueValue("SELECT stock_id FROM stock_details WHERE stock_name='".$row['stock_name']."' AND stock_id='".$row['stock_id']."'");
											echo $ss; 
										?>
									</td>
									<td>
										<?php 
											$category = $db->queryUniqueValue("SELECT category FROM stock_details WHERE stock_name='".$row['stock_name']."' AND category='".$row['category']."'");

											echo $category; 
										?>
									</td>
									<td>
										<?php 
											$name = $db->queryUniqueValue("SELECT stock_name FROM stock_details WHERE stock_name='".$row['stock_name']."'");
											echo $name; 
										?>
									</td>
									<td>
										<?php 
											$quantity = $db->queryUniqueValue("SELECT stock_quatity FROM stock_details WHERE stock_name='".$row['stock_name']."' AND stock_quatity='".$row['stock_quatity']."'");
											echo $quantity; 
										?>
									</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
<?php $i++; } ?>

 <tr>

       <td align="center" colspan="9"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
</form>
</table>
                    </div>
				
			    
		
		</div> <!-- end full-width -->
			
                </div>
            </div>
        <div>
     
        </div>
	
	<!-- FOOTER -->
	<div id="footer">
    <p> &copy;SsekirandaEdgarWatson 2023</p>
	<div id="fb-root">
    
</div>
		
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=286371564842269";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
	</div> <!-- end footer -->

</body>
</html