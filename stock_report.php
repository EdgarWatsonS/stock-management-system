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

// Retrieve the stock added data for the selected month and year
$stockAddedResult = $db->query("SELECT * FROM stock_added WHERE MONTH(date) = '$selectedMonth' AND YEAR(date) = '$selectedYear'");
$stockAddedData = array();
while ($row = $stockAddedResult->fetch_array()) {
    $stockAddedData[] = $row;
}

// Retrieve the stock subtracted data for the selected month and year
$stockSubtractedResult = $db->query("SELECT * FROM stock_entries WHERE MONTH(date) = '$selectedMonth' AND YEAR(date) = '$selectedYear'");
$stockSubtractedData = array();
while ($row = $stockSubtractedResult->fetch_array()) {
    $stockSubtractedData[] = $row;
}


// Retrieve the distinct months and years for which either stock added or stock subtracted data exists
$availableMonths = $db->query("SELECT DISTINCT MONTH(date) AS month, YEAR(date) AS year FROM stock_added 
                              UNION SELECT DISTINCT MONTH(date) AS month, YEAR(date) AS year FROM stock_entries");

// Function to get the stock name and quantity for a given month and year
function getStockQuantity($stockData, $stockName) {
    $quantity = 0;
    foreach ($stockData as $row) {
        if ($row['stock_name'] === $stockName) {
            $quantity += $row['quantity'];
        }
    }
    return $quantity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stock Quantity Report</title>
    
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
                <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
                <li><a href="view_product.php" class="active-tab stock-tab">Stocks / Products</a></li>
                <li><a href="outgoing.php" class="payment-tab">Stock Out</a></li>
                <li><a href="stock_quantity_report.php" class="report-tab">Stock Quantity Report</a></li>
            </ul> <!-- end tabs -->
            
            <!-- Change this image to your own company's logo -->
            <!-- The logo will automatically be resized to 30px height. -->
            <a href="#" id="company-branding-small" class="fr"><img src="upload/logos.jpg" alt="Point of Sale" /></a> 
            
        </div> <!-- end full-width -->   
    </div> <!-- end header -->
    
    <!-- MAIN CONTENT```php
    <div id="content">
        <div class="page-full-width cf">
            <div class="side-menu fl">
                <h3>Stock Management</h3>
                <ul>
                    <li><a href="stock_report.php">Stock Subtracted Report</a></li>
                </ul>
            </div> <!-- end side-menu -->
            <div class="side-content fr">
                <div class="content-module">
                    <div class="content-module-heading cf">
                        <h3 class="fl">Stock Quantity Report - <?php echo date('F Y', strtotime($selectedYear . '-' . $selectedMonth . '-01')); ?></h3>
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
                        </div>
                        <table class="tbl-report">
                            <thead>
                                <tr>
                                <th>Stock Name</th>
                                    <th>Stock ID</th>
                                    <th>Category</th>
                                    <th>Quantity Added</th>
                                    <th>Quantity Subtracted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get unique stock names from both tables and store in an array
                                $allStockNames = array_unique(array_merge(array_column($stockAddedData, 'stock_name'), array_column($stockSubtractedData, 'stock_name')));

                                // Loop through the stock names and display the details
                                foreach ($allStockNames as $stockName) {
                                    echo "<tr>";
                                    echo "<td>{$stockName}</td>";

                                    // Retrieve the stock ID and category for the stock name
                                    $stockID = '';
                                    $category = '';
                                    foreach ($stockAddedData as $row) {
                                        if ($row['stock_name'] === $stockName) {
                                            $stockID = $row['stock_id'];
                                            $category = $row['category'];
                                            break;
                                        }
                                    }

                                    echo "<td>{$stockID}</td>";
                                    echo "<td>{$category}</td>";

                                    // Get stock quantity added for the given month and year
                                    $quantityAdded = getStockQuantity($stockAddedData, $stockName);
                                    echo "<td>{$quantityAdded}</td>";

                                    // Get stock quantity subtracted for the given month and year
                                    $quantitySubtracted = getStockQuantity($stockSubtractedData, $stockName);
                                    echo "<td>{$quantitySubtracted}</td>";

                                    echo "</tr>";
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
        <p>&copy; SsekirandaEdgarWatson 2023</p>
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
