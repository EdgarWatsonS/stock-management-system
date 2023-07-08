<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Update Stock</title>
	
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
	<link rel="stylesheet" href="css/style.css">
	
	<!-- Optimize for mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- jQuery & JS files -->
	<?php include_once("tpl/common_js.php"); ?>
	<script src="js/script.js"></script>  
		<script>
	/*$.validator.setDefaults({
		submitHandler: function() { alert("submitted!"); }
	});*/
	$(document).ready(function() {
	
		// validate signup form on keyup and submit
		$("#form1").validate({
			rules: {
				name: {
					required: true,
					minlength: 3,
					maxlength: 200
				},
				
				
			},
			messages: {
				name: {
					required: "Please enter a Stock Name",
					minlength: "Stock must consist of at least 3 characters"
				},
				
			}
		});
	
	});
function numbersonly(e){
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=38 && unicode!=39 && unicode!=40){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57)
        return false
    }
    }
	</script>

</head>
<body>

	<!-- TOP BAR -->
	<?php include_once("tpl/top_bar.php"); ?>
	<!-- end top-bar -->
	
	
	
	<!-- HEADER -->
	<div id="header-with-tabs">
		
		<div class="page-full-width cf">
	
			<ul id="tabs" class="fl">
                                <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
				<!--<li><a href="view_sales.php" class="sales-tab">Sales</a></li>
				<li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
				
				<li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li> -->
				<li><a href="view_product.php" class="active-tab stock-tab">Stocks / Products</a></li>
			<!--	<li><a href="view_payments.php" class="payment-tab">Payments / Outstandings</a></li>
				<li><a href="view_report.php" class="report-tab">Reports</a></li> -->
			</ul> <!-- end tabs -->
			
			<!-- Change this image to your own company's logo -->
			<!-- The logo will automatically be resized to 30px height. -->
		
			
		</div> <!-- end full-width -->	

	</div> <!-- end header -->
	
	
	
	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="page-full-width cf">

			<div class="side-menu fl">
				
				<h3>Stock Management</h3>
				<ul>
					<li><a href="add_stock.php">Add Stock/Product</a></li>
					<li><a href="view_product.php">View Stock/Product</a></li>
				<!--	<li><a href="add_category.php">Add Stock Category</a></li>
					<li><a href="view_category.php">view Stock Category</a></li>
                                        <li><a href="view_stock_availability.php">view Stock Available</a></li> -->                                      
				</ul>
				                            
			</div> <!-- end side-menu -->
			
			<div class="side-content fr">
			
				<div class="content-module">
				
					<div class="content-module-heading cf">
					
						<h3 class="fl">Update Stock</h3>
						<span class="fr expand-collapse-text">Click to collapse</span>
						<span class="fr expand-collapse-text initial-expand">Click to expand</span>
					
					</div> <!-- end content-module-heading -->
					
						<div class="content-module-main cf">
				<form name="form1" method="post" id="form1" action="">
                  <p><strong>Add Stock Details </strong> - Add New ( Control + U)</p>
                  <table class="form"  border="0" cellspacing="0" cellpadding="0">
				  <?php
				if (isset($_POST['id'])) {
					$id = $_POST['id'];
					$stock_id = trim($_POST['stock_id']);
					$name = trim($_POST['name']);
					$category = trim($_POST['category']);
					$date = trim($_POST['date']);
					$stock_quatity = trim($_POST['stock_quatity']);
					$stock_subtraction = trim($_POST['stock_subtraction']);
					$stock_addition = trim($_POST['stock_addition']);
				
					// Retrieve the original stock_quatity from stock_details table
					$result = $db->query("SELECT stock_quatity FROM stock_details WHERE id=$id");
					$originalQuantity = $result->fetch_assoc()['stock_quatity'];
				
					// Calculate the new quantity by adding the stock addition and subtracting the stock subtraction
                           $newQuantity = $stock_quatity + $stock_addition - $stock_subtraction;

                           // Update stock details in stock_details table
                        if ($db->query("UPDATE stock_details SET stock_name='$name', stock_quatity='$newQuantity', category='$category', date='$date' WHERE id=$id")) {
    

							if ($stock_addition > 0) {
								// Insert the stock addition as a new entry in stock_added table
								$db->query("INSERT INTO stock_added (stock_id, stock_name, stock_quatity, category, date) VALUES ('$stock_id', '$name', '$stock_addition', '$category', '$date')");
							} elseif ($stock_subtraction > 0) {
								// Insert the stock subtraction as a new entry in stock_out table
								$db->query("INSERT INTO stock_out (stock_id, stock_name, stock_quatity, category, date) VALUES ('$stock_id', '$name', '$stock_subtraction', '$category', '$date')");
							}
				

				
						$data = "$name - Stock Details Updated";
						$msg = '<p style="color:#153450;font-family:Georgia, Times New Roman, Times, serif">' . $data . '</p>';
						header("Location: view_product.php?msg=$msg");


						
						?>
						<script src="dist/js/jquery.ui.draggable.js"></script>
						<script src="dist/js/jquery.alerts.js"></script>
						<script src="dist/js/jquery.js"></script>
						<link rel="stylesheet" href="dist/js/jquery.alerts.css">
						<script type="text/javascript">
							jAlert('<?php echo $msg; ?>', 'POSNIC');
							header("Location: dashboard.php?msg=$msg");
						</script>
						<?php
					} else {
						echo "<br><font color='red' size='+1'>Problem in Updation!</font>";
						
			
			}
		}
				
				?>	
				<?php 
				if(isset($_GET['sid']))
				$id=$_GET['sid'];
			
				$line = $db->queryUniqueObject("SELECT * FROM stock_details WHERE id=$id");
				?>
		<form name="form1" method="post" id="form1" action="">
    <input name="id" type="hidden" value="<?php echo $_GET['sid']; ?>">
        <tr>
            
            <td>Stock ID: </td>
           <td> <input name="stock_id" type="text" id="stock_id" maxlength="200" class="round default-width-input" value="<?php echo $line->stock_id; ?>" /></td>
        
            <td>Name</td>
			<td><input name="name" type="text" id="name" maxlength="200" class="round default-width-input" value="<?php echo $line->stock_name; ?>" /></td>
	</tr>
	<tr>
			<td>Category</td>
            <td><input name="category" type="text" id="category" maxlength="20" class="round default-width-input" value="<?php echo $line->category; ?>" /></td>
       
            <td>Quantity</td>
			<td><input name="stock_quatity" type="text" id="stock_quatity" maxlength="20" class="round default-width-input" value="<?php echo $line->stock_quatity; ?>" /></td>
	</tr>
    <tr>
            <td>Stock Subtraction</td>
            <td><input name="stock_subtraction" type="text" id="stock_subtraction" maxlength="20" class="round default-width-input" /></td>
            <td>Stock Addition</td>
            <td><input name="stock_addition" type="text" id="stock_addition" maxlength="20" class="round default-width-input" /></td>
        </tr>
		<tr>
            <td>Date</td>
            <td><input name="date" type="text" id="date" maxlength="20" class="round default-width-input" value="<?php echo $line->date; ?>" /></td>
        </tr>
        <tr>
		<tr>&nbsp;</tr>
		<td>&nbsp;</td>
            <td>
                <input class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Save">
                (Control + S)
            </td>
            <td align="right">
                <input class="button round red text-upper" type="reset" name="Reset" value="Reset">
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</form>



						
				
					</div> <!-- end content-module-main -->
							
				
				</div> <!-- end content-module -->
				
				
		
		</div> <!-- end full-width -->
			
	</div> <!-- end content -->
	
	
	
	<!-- FOOTER -->
	<div id="footer">
		<p> &copy;</p>
	
	</div> <!-- end footer -->

</body>
</html>