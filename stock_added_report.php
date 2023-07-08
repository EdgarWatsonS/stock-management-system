<?php
include_once("init.php");

// Get the selected month and year from the URL parameters
if (isset($_GET['month']) && isset($_GET['year'])) {
    $selectedMonth = $_GET['month'];
    $selectedYear = $_GET['year'];
} else {
    // If no month and year are specified, use the current month and year
    $selectedMonth = date('m');
    $selectedYear = date('Y');
}

// Retrieve the stock subtracted data for the selected month and year
$stockSubtractedData = $db->query("SELECT * FROM stock_added WHERE MONTH(date) = '$selectedMonth' AND YEAR(date) = '$selectedYear'");

// Retrieve the distinct months and years for which stock subtracted data exists
$availableMonths = $db->query("SELECT DISTINCT MONTH(date) AS month, YEAR(date) AS year FROM stock_added");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stock Added Report</title>
    
    <!-- Stylesheets -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
				<li><a href="view_product.php" class=" stock-tab">Stocks / Products</a></li>
				<li><a href="stock_added_report.php" class="report-tab">Stock In Report</a></li>
				<li><a href="stock_out_report.php" class="report-tab">Stock Out Report</a></li>
			<!--	<li><a href="view_report.php" class="active-tab report-tab">Reports</a></li> -->
			<!--	<li><a href="view_report.php" class="report-tab">Reports</a></li> -->
			</ul><!-- end tabs -->
            
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
                        <h3 class="fl">Stock Added Report - <?php echo date('F Y', strtotime($selectedYear . '-' . $selectedMonth . '-01')); ?></h3>
                    </div> <!-- end content-module-heading -->
                    <div class="content-module-main">
                        <div class="filter-section">
                        <form action="" method="GET" style="display: flex;">
    <div>
    <label for="year" style="font-family: 'Droid Sans', Arial, sans-serif; color: #333; font-size: 12px; margin-right: 10px;">Select Year:</label>
    <select name="year" id="year" style="font-family: 'Droid Sans', Arial, sans-serif; color: #333; margin-right: 10px;">
            <?php
            // Display the available years in the select dropdown
            $currentYear = date('Y');
            for ($i = $currentYear; $i >= 2000; $i--) {
                $selected = ($i == $selectedYear) ? 'selected' : '';
                echo "<option value=\"$i\" $selected>$i</option>";
            }
            ?>
        </select>
    </div>
    <div>
    <label for="month" style="font-family: 'Droid Sans', Arial, sans-serif; color: #333; font-size: 12px; margin-right: 10px;">Select Month:</label>
    <select name="month" id="month" style="font-family: 'Droid Sans', Arial, sans-serif; color: #333; margin-right: 10px;">
            <?php
            // Display all the months in the select dropdown
            $months = [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
                7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ];
            foreach ($months as $monthValue => $monthText) {
                $selected = ($monthValue == $selectedMonth) ? 'selected' : '';
                echo "<option value=\"$monthValue\" $selected>$monthText</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <input type="submit" value="Filter" style="font-family: 'Droid Sans', Arial, sans-serif; background-color: blue; color: #fff; padding: 5px 10px; border: none; cursor: pointer;">
    </div>
</form>

<br>

                        </div>
                        <table class="tbl-report">
                            <thead>
                                <tr>
                                    <th>Stock ID</th>
                                    <th>Stock Name</th>
                                    <th>Category</th>
                                    <th>Quantity Added</th>
                                    <th>Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through the stock subtracted data and display the details
                                if ($stockSubtractedData) {
                                    foreach ($stockSubtractedData as $row) {
                                        echo "<tr>";
                                        echo "<td>{$row['stock_id']}</td>";
                                        echo "<td>{$row['stock_name']}</td>";
                                        echo "<td>{$row['category']}</td>";
                                        echo "<td>{$row['stock_quatity']}</td>";
                                        echo "<td>{$row['date']}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No stock subtracted for the selected month and year.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> <!-- end content-module-main -->
                </div> <!-- end content-module -->
            </div> <!-- end side-content -->
        </div> <!-- end full-width -->
    </div> <!-- end content -->
    <!-- Print button -->
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="printTable()">Print Table</button>
    </div>
    
    <div id="footer">
        <p>&copy;SsekirandaEdgarWatson 2023</p>
    </div> <!-- end footer -->
    <script>
    function printTable() {
        var tableHeaders = document.querySelectorAll('.tbl-report thead tr th');
        var tableRows = document.querySelectorAll('.tbl-report tbody tr');
        
        var printContents = '<table class="tbl-report">';
        printContents += '<thead><tr>';
        
        // Append table headers
        for (var i = 0; i < tableHeaders.length; i++) {
            printContents += tableHeaders[i].outerHTML;
        }
        
        printContents += '</tr></thead>';
        
        printContents += '<tbody>';
        
        // Append table rows
        for (var j = 0; j < tableRows.length; j++) {
            printContents += tableRows[j].outerHTML;
        }
        
        printContents += '</tbody></table>';

        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

</body>
</html>
