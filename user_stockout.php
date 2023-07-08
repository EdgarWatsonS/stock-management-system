<?php
include_once("init.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Subtract Stock</title>
    
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

<!--    <script>
    $(document).ready(function() {
        $("#product").autocomplete("product.php", {
            width: 160,
            autoFill: true,
            selectFirst: true
        });

        // validate form on keyup and submit
        $("#form1").validate({
            rules: {
                product: {
                    required: true,
                    minlength: 3,
                    maxlength: 200
                },
                quantity: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                product: {
                    required: "Please enter the product name",
                    minlength: "Product name must consist of at least 3 characters"
                },
                quantity: {
                    required: "Please enter the quantity",
                    digits: "Please enter a valid quantity"
                }
            }
        });
    });
    </script> -->

</head>
<body>

<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->



<!-- HEADER -->
<div id="header-with-tabs">
    
    <div class="page-full-width cf">

    <ul id="tabs" class="fl">
				<li><a href="user_dashboard.php" class="active-tab dashboard-tab">Dashboard</a></li>
			<!--	<li><a href="view_product.php" class=" stock-tab">Stocks / Products</a></li>
				<li><a href="outgoing.php" class="payment-tab">Stock Out</a></li>
				<li><a href="stock_added_report.php" class="report-tab">Stock In Report</a></li> 
				<li><a href="stock_out_report.php" class="report-tab">Stock Out Report</a></li> -->
			<!--	<li><a href="view_report.php" class="active-tab report-tab">Reports</a></li> -->
			<!--	<li><a href="view_report.php" class="report-tab">Reports</a></li> -->
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
            
        <h3>Quick Links</h3>
				<ul>
					<!--<li><a href="add_stock.php">Add Stock/Product</a></li>
						<li><a href="view_product.php">View Stock</a></li> -->
					<li><a href="outgoing.php"> Register Stock Out</a></li>
					<!--<li><a href="stock_added_report.php">Stock Added Report</a></li> -->
					<li><a href="stock_out_report.php">Stock out Report</a></li>	
				</ul>
        </div> <!-- end side-menu --> 
                
        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Subtract Stock
                    </h3>
                </div> <!-- end content-module-heading -->

                <div class="content-module-main cf">
                    <?php
                    if(isset($_POST['stock_name']) && isset($_POST['stock_quatity'])) {
                        $stock_id = $_POST['stock_id'];
                        $product = $_POST['stock_name'];
                        $category = $_POST['category'];
                        $quantity = $_POST['stock_quatity'];
                        $error = false;

                        // Validate product name and quantity
                        if(strlen($product) < 3 || strlen($product) > 200) {
                            $error = true;
                            echo "<div class='error-box round'>Product name must be between 3 and 200 characters.</div>";
                        }

                        if(!is_numeric($quantity) || $quantity < 1) {
                            $error = true;
                            echo "<div class='error-box round'>Invalid quantity. Please enter a valid positive number.</div>";
                        }

                        if(!$error) {
                            // Subtract quantity from stock
                            $selectQuery = "SELECT * FROM stock_details WHERE stock_name = '$product'";
                            $result = mysqli_query($conn, $selectQuery);
                            
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $currentQuantity = $row['stock_quatity'];
                                $newQuantity = $currentQuantity - $quantity;
                            
                                // Update the stock quantity in the database
                                $updateQuery = "UPDATE stock_details SET stock_quatity = '$newQuantity' WHERE stock_name = '$product'";
                                $updateResult = mysqli_query($conn, $updateQuery);
                            
                                if ($updateResult) {
                                    // Store the subtracted stock in the stock_subtraction table
                                    $current_date = date("Y-m-d"); // Get the current date
                                    $insertQuery = "INSERT INTO stock_entries (stock_id, stock_name, category, stock_quatity, date)
                                                    VALUES ('$stock_id', '$product', '$category', '$quantity', '$current_date')";
                                    $insertResult = mysqli_query($conn, $insertQuery);
                            
                                    if ($insertResult) {
                                        echo "<div class='success-box round'>Stock quantity for '$product' has been updated and subtracted stock has been stored.</div>";
                                    } else {
                                        echo "<div class='error-box round'>Failed to store subtracted stock. Please try again.</div>";
                                        echo "Insert Error: " . mysqli_error($conn); // Print the error message
                                    }
                                } else {
                                    echo "<div class='error-box round'>Failed to update stock quantity. Please try again.</div>";
                                    echo "Update Error: " . mysqli_error($conn); // Print the error message
                                }
                            } else {
                                echo "<div class='error-box round'>Failed to fetch stock details. Please try again.</div>";
                                echo "Query Error: " . mysqli_error($conn); // Print the error message
                            }
                        }}
                        // ...
                        ?>
                    <form action="#" method="post" id="form1">
                    <p>
                            <label for="stock_id" class="req">Storage Space</label>
                            <input type="text" id="Stock_id" name="stock_id" class="round default-width-input" />
                        </p>
                        <p>
                            <label for="product" class="req">Product Name</label>
                            <input type="text" id="Stock_name" name="stock_name" class="round default-width-input" />
                        </p>
                        <p>
                            <label for="category" class="req">Category</label>
                            <input type="text" id="category" name="category" class="round default-width-input" />
                        </p>

                        <p>
                            <label for="quantity" class="req">Quantity</label>
                            <input type="text" id="stock_quatity" name="stock_quatity" class="round default-width-input" />
                        </p>

                        <input type="submit" class="button round blue image-right ic-add text-upper" value="Submit" />
                    </form>
                </div> <!-- end content-module-main -->

            </div> <!-- end content-module -->

        </div> <!-- end side-content -->

    </div> <!-- end full-width -->

</div> <!-- end content -->

<!-- FOOTER -->
<div id="footer">
    <p> &copy;SsekirandaEdgarWatson 2023</p>
</div> <!-- end footer -->

</body>
</html>
