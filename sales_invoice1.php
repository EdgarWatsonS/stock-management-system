<?php
include_once("init.php");// Use session variable on this page. This function must put on the top of page.
if(!isset($_SESSION['username']) || $_SESSION['usertype'] !='admin'){ // if session variable "username" does not exist.
header("location:index.php?msg=Please%20login%20to%20access%20admin%20area%20!"); // Re-direct to index.php
}
else
{
 if(isset($_GET['sellid'])  && $_GET['sellid']!=''  ){

	
	$userid=$_GET['sellid'];
			
		  	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sale Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<style type="text/css" media="print">
.hide{display:none}
@media print{
  #printButton{
    display: none
  }
}
</style>
<script type="text/javascript">
function printpage() {
document.getElementById('printButton').style.visibility="hidden";
window.print();
document.getElementById('printButton').style.visibility="visible";  
}
</script>
<body>
<input name="print" type="button" value="Print" id="printButton" onClick="printpage()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
         <div align="right">
                      <?php $line4 = $db->queryUniqueObject("SELECT * FROM store_details ");
				 ?>
                  <strong><?php echo $line4->name; ?></strong><br />
                  <?php echo $line4->address; ?><br/>
                  
             Phone<strong>:<?php echo $line4->phone; ?></strong>
                  <br />
                  <?php ?>
              </div>
      <table width="595" border="0" cellspacing="0" cellpadding="0">
       
        <tr>
          <td height="30" align="center"><strong>Sales Report </strong></td>
        </tr>
       
       
        <tr>
          <td ><hr></td>
        </tr>
        
        <tr>
          <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><strong>Date</strong></td>
                <td><strong>Sales ID </strong></td>
                 <td><strong>Customer</strong></td>
                <td><strong>Product </strong></td>
                <td><strong>Price </strong></td>
                <td><strong>Quantity</strong></td>
               
                <td><strong>Total</strong></td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  <?php 
			
		   $result = $db->query("SELECT * FROM stock_sales where transactionid=$userid ");
	   		  
		while ($line = $db->fetchNextObject($result)) {
?>
			
				<tr>
                <td><?php  $mysqldate=$line->date;
 		$phpdate = strtotime( $mysqldate );
 		$phpdate = date("d/m/Y",$phpdate);
		echo $phpdate; ?></td>
                <td><?php echo $line->transactionid; ?></td>
                 <td><?php echo $line->customer_id; ?></td>
                 <td><?php echo $line->stock_name; ?></td>
               <td><?php echo $line->selling_price; ?></td>
                <td><?php echo $line->quantity; ?></td>
                <td><?php echo $line->amount; ?></td>
               
              </tr>
			  	
          
<?php
}
?>
</table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>

</body>
<footer>

<p align="center"> Software Developed By: <strong>Ahsan Riaz</strong> </br>
Email: ahsanriaz26@gmail.com</p>
</footer>
<script>
  window.onload = (event) => {
   window.print()
   setTimeout(function(){ window.close() },750)
  };
</script>
</html>
<?php
}

else{
echo "Please Select transiction i.d to process report";

}
}

?>