<?php
include_once("init.php");

if (isset($_POST['name'])) {
    $_POST = $gump->sanitize($_POST);
    $gump->validation_rules(array(
        'name' => 'required|max_len,100|min_len,3',
        'stock_id' => 'required|max_len,200',
        'supplier' => 'max_len,200',
        'stock_quatity' => 'required|numeric',
        'category' => 'max_len,200'
    ));

    $gump->filter_rules(array(
        'name' => 'trim|sanitize_string|mysqli_escape',
        'stock_id' => 'trim|sanitize_string|mysqli_escape',
        'category' => 'trim|sanitize_string|mysqli_escape',
        'stock_quatity' => 'trim|sanitize_numbers',
        'supplier' => 'trim|sanitize_string|mysqli_escape'
    ));

    $validated_data = $gump->run($_POST);

    if ($validated_data === false) {
        echo $gump->get_readable_errors(true);
    } else {
        $name = $_POST['name'];
        $stock_id = $_POST['stock_id'];
        $supplier = $_POST['supplier'];
        $category = $_POST['category'];
        $stock_quatity = $_POST['stock_quatity'];

        // Check if the stock already exists in the database
		$count = $db->countOf("stock_details", "stock_id = '$stock_id' AND stock_name = '$name' AND category = '$category'");
		if ($count > 0) {
			// Stock already exists, update the stock quantity
			$db->query("UPDATE stock_details SET stock_quatity = stock_quatity + $stock_quatity WHERE stock_id = '$stock_id'  AND stock_name = '$name' AND category = '$category'");
            
            $msg = "$stock_quatity quantity added to $name";
            header("Location: dashboard.php?msg=$msg");
            
		} else {
        // Stock does not exist, insert a new stock
        if ($db->query("INSERT INTO stock_details(stock_id, stock_name, stock_quatity, category) VALUES ('$stock_id','$name','$stock_quatity','$category')")) {
            
		}
	}
            // Insert into the 'stock_added' table
            $current_date = date("Y-m-d"); // Get the current date
            $db->query("INSERT INTO stock_added(stock_id, stock_name, category, stock_quatity, date) VALUES ('$stock_id', '$name', '$category', '$stock_quatity', '$current_date')");

            $msg = "$name Stock Details Added";
            header("Location: dashboard.php?msg=$msg");
            exit;
        } 
    }


if (isset($_GET['msg'])) {
    $data = $_GET['msg'];
    $msg = '<p style="color:#153450;font-family:Georgia, Times New Roman, Times, serif">' . $data . '</p>';
    ?>
    <script src="dist/js/jquery.ui.draggable.js"></script>
    <script src="dist/js/jquery.alerts.js"></script>
    <script src="dist/js/jquery.js"></script>
    <link rel="stylesheet" href="dist/js/jquery.alerts.css">

    <script type="text/javascript">
        jAlert('<?php echo  $msg; ?>', 'POSNIC')
    </script>

  

    </script>
    <?php
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Add Stock</title>
	
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
	<link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="js/date_pic/date_input.css">
        <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">
	
	<!-- Optimize for mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- jQuery & JS files -->
	<?php include_once("tpl/common_js.php"); ?>
	<script src="js/script.js"></script>  
        <script src="js/date_pic/jquery.date_input.js"></script>  
        <script src="lib/auto/js/jquery.autocomplete.js "></script>  
 
		<script>
	/*$.validator.setDefaults({
		submitHandler: function() { alert("submitted!"); }
	});*/
	$(document).ready(function() {
		$("#supplier").autocomplete("supplier1.php", {
		width: 160,
		autoFill: true,
		selectFirst: true
	});
	
		// validate signup form on keyup and submit
		$("#form1").validate({
			rules: {
				name: {
					required: true,
					minlength: 3,
					maxlength: 200
				},
				stock_id: {
					required: true,
					minlength: 3,
					maxlength: 200
				},
				stock_quatity: {
				   required: true,	
				}
			},
			messages: {
				name: {
					required: "Please Enter Stock Name",
					minlength: "Category Name must consist of at least 3 characters"
				},
				stock_id: {
					required: "Please Enter Stock ID",
					minlength: "Category Name must consist of at least 3 characters"
				}
			}
		});
	
	});
function numbersonly(e){
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=38 && unicode!=39 && unicode!=40 && unicode!=9){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57)
        return false
    }
    }
	</script>
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
				<li><a href="view_product.php" class="active-tab stock-tab">Stocks / Products</a></li>
				<li><a href="outgoing.php" class="payment-tab">Stock Out</a></li>
			</ul> <!-- end tabs -->
			
			<!-- Change this image to your own company's logo -->
			<!-- The logo will automatically be resized to 30px height. -->
			<a href="#" id="company-branding-small" class="fr"><img src="upload/logos.jpg" alt="Point of Sale" /></a> 
			
		</div> <!-- end full-width -->	

	</div> <!-- end header -->
	
	
	
	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="page-full-width cf">

			<div class="side-menu fl">
				
				<h3>Stock Management</h3>
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
					
						<h3 class="fl">Add Stock </h3>
						<span class="fr expand-collapse-text">Click to collapse</span>
                                                <div style="margin-top: 15px;margin-left: 150px"></div>
						<span class="fr expand-collapse-text initial-expand">Click to expand</span>
					
					</div> <!-- end content-module-heading -->
					
						<div class="content-module-main cf">
				
							
					
                                                        <?php
                                         
				
				?>
				
				<form name="form1" method="post" id="form1" action="">
                  
                
                  <table class="form"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                          <?php
					  $max = $db->maxOfAll("id", "stock_details");
					  $max=$max;
					  $id="SS".$max."";
					  ?>
                      <td>STORAGE SPACE:</td>
                      <td><input name="stock_id" type="text" id="stock_id"  maxlength="200"  class="round default-width-input" value="<?php echo $stock_id; ?>" /></td>
                       
                      <td></span>Name:</td>
                      <td><input name="name"placeholder="ENTER  NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $name; ?>" /></td>
                       
                    </tr>
                    <tr>
					<td>Category:</td>
                      <td><input name="category" placeholder="ENTER CATEGORY NAME" type="text" id="category" maxlength="200"  class="round default-width-input" value="<?php echo $category; ?>" /></td>
					  
					  <td>Quantity</td>
                      <td><input name="stock_quatity" placeholder="ENTER QUANTITY" type="text" id="stock_quatity" maxlength="200"  class="round default-width-input" value="<?php echo $stock_quatity; ?>" /></td>
                    </tr>
					<tr>
					
										</tr>
                   
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    
                    
                    <tr>
                      <td>&nbsp;
					 
					  </td>
                      <td>
                        <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Add">
						
					  
					  <td align="right"><input class="button round red   text-upper"  type="reset" name="Reset" value="Reset"> </td>
                    </tr>
                  </table>
                </form>  
						
				
					</div> <!-- end content-module-main -->
							
				
				</div> <!-- end content-module -->
				
				
		
		</div> <!-- end full-width -->
		  	
	</div> <!-- end content -->
	
	
	
	<!-- FOOTER -->
	<div id="footer">
        
		<p> &copy;SsekirandaEdgarWatson 2023</p>

	
	</div> <!-- end footer -->

</body>
</html>