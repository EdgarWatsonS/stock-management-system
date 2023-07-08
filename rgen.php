<?php
include_once("init.php");

// Function to generate monthly report for stock added
function generateStockAddedReport($conn, $month, $year) {
    $query = "SELECT * FROM stock_details WHERE MONTH(date_added) = $month AND YEAR(date_added) = $year";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h4>Stock Added Report - " . date('F Y', strtotime($year . '-' . $month . '-01')) . "</h4>";
        echo "<table>";
        echo "<tr><th>Product</th><th>Quantity</th><th>Date Added</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $product = $row['stock_name'];
            $quantity = $row['stock_quatity'];
            $dateAdded = $row['date_added'];

            echo "<tr><td>$product</td><td>$quantity</td><td>$dateAdded</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No stock added for the specified month and year.</p>";
    }
}

// Function to generate monthly report for stock out
function generateStockOutReport($conn, $month, $year) {
    $query = "SELECT * FROM stock_out WHERE MONTH(date_out) = $month AND YEAR(date_out) = $year";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h4>Stock Out Report - " . date('F Y', strtotime($year . '-' . $month . '-01')) . "</h4>";
        echo "<table>";
        echo "<tr><th>Product</th><th>Quantity</th><th>Date Out</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $product = $row['product'];
            $quantity = $row['quantity'];
            $dateOut = $row['date_out'];

            echo "<tr><td>$product</td><td>$quantity</td><td>$dateOut</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No stock out for the specified month and year.</p>";
    }
}

// Check if the report form is submitted
if (isset($_POST['report_month']) && isset($_POST['report_year'])) {
    $month = $_POST['report_month'];
    $year = $_POST['report_year'];

    // Generate stock added report
    generateStockAddedReport($conn, $month, $year);

    // Generate stock out report
    generateStockOutReport($conn, $month, $year);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head section content... -->
</head>
<body>
    <!-- Top bar, header, and other HTML content... -->

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="page-full-width cf">
            <div class="side-menu fl">
                <!-- Side menu content... -->
            </div>

            <div class="side-content fr">
                <div class="content-module">
                    <div class="content-module-heading cf">
                        <h3 class="fl">Subtract Stock</h3>
                    </div>

                    <div class="content-module-main cf">
                        <!-- Existing code for subtracting stock... -->

                        <!-- Monthly report form -->
                        <div class="content-module">
                            <div class="content-module-heading cf">
                                <h3 class="fl">Monthly Reports</h3>
                            </div>

                            <div class="content-module-main cf">
                                <form action="#" method="post">
                                    <p>
                                        <label for="report_month">Month</label>
                                        <select name="report_month" id="report_month">
                                            <!-- Options for selecting the month... -->
                                        </select>
                                    </p>
                                    <p>
                                        <label for="report_year">Year</label>
                                        <select name="report_year" id="report_year">
                                            <!-- Options for selecting the year... -->
                                        </select>
                                    </p>
                                    <input type="submit" class="button round blue image-right ic-add text-upper" value="Generate Report" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer and other HTML content... -->
</body>
</html>
