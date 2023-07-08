<?php
include_once("init.php"); // Use session variable on this page. This function must be placed at the top of the page.
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') { // If session variable "username" does not exist.
    header("location:index.php?msg=Please%20login%20to%20access%20the%20admin%20area!"); // Redirect to index.php
} else {
    if (isset($_GET['from_date']) && isset($_GET['to_date']) && $_GET['from_date'] != '' && $_GET['to_date'] != '') {

        $fromDate = $_GET['from_date'];
        $toDate = $_GET['to_date'];

        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
        <html>
        <head>
            <title>Stock Report</title>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        </head>
        <style type="text/css" media="print">
            .hide {
                display: none
            }
        </style>
        <script type="text/javascript">
            function printpage() {
                document.getElementById('printButton').style.visibility = "hidden";
                window.print();
                document.getElementById('printButton').style.visibility = "visible";
            }
        </script>
        <body>
        <input name="print" type="button" value="Print" id="printButton" onClick="printpage()">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <div align="right">
                        <?php
                        $line4 = $db->queryUniqueObject("SELECT * FROM store_details ");
                        ?>
                        <strong><?php echo $line4->name; ?></strong><br/>
                        <?php echo $line4->address; ?>,<?php echo $line4->place; ?>, <br/>
                        <?php echo $line4->city; ?>,<?php echo $line4->pin; ?><br/>
                        Website<strong>:<?php echo $line4->web; ?></strong><br>Email<strong>:<?php echo $line4->email; ?></strong><br/>
                        Phone
                        <strong>:<?php echo $line4->phone; ?></strong>
                        <br/>
                    </div>
                    <table width="595" border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td height="30" align="center"><strong>Stock Report </strong></td>
                        </tr>
                        <tr>
                            <td height="30" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="left">
                                            <table width="300" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="150"><strong>Total Stock In</strong></td>
                                                    <td width="150">&nbsp;<?php echo $db->queryUniqueValue("SELECT sum(stock_quatity) FROM stock_entries WHERE type='entry' AND date BETWEEN '$fromDate' AND '$toDate'"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Stock Out</strong></td>
                                                    <td>&nbsp;<?php echo $db->queryUniqueValue("SELECT sum(stock_quatity) FROM stock_entries WHERE type='exit' AND date BETWEEN '$fromDate' AND '$toDate'"); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td align="right">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="45"><hr></td>
                        </tr>
                        <tr>
                            <td height="20">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="45"><strong>From</strong></td>
                                        <td width="393">&nbsp;<?php echo $_GET['from_date']; ?></td>
                                        <td width="41"><strong>To</strong></td>
                                        <td width="116">&nbsp;<?php echo $_GET['to_date']; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="45"><hr></td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="20%"><strong>Date</strong></td>
                                        <td width="20%"><strong>Item</strong></td>
                                        <td width="20%"><strong>Type</strong></td>
                                        <td width="20%"><strong>Quantity</strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <?php
                                    $result = $db->query("SELECT * FROM stock_entries WHERE date BETWEEN '$fromDate' AND '$toDate' ORDER BY date ASC");
                                    while ($line = $db->fetchNextObject($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo date("d/m/Y", strtotime($line->date)); ?></td>
                                            <td><?php echo $line->stock_name; ?></td>
                                            <td><?php echo $line->type; ?></td>
                                            <td><?php echo $line->quantity; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        </body>
        </html>
        <?php
    } else {
        echo "Please select a from date and to date to generate the report.";
    }
}
?>
