<?php
//include('header.php'); 
include 'db_connect.php';

 ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

?>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="invoice.js"></script>
  
<style>
.invoice_container{
	margin:0 auto;
	margin-top:35px;
	padding:40px;
	width:750px;
	height:auto;
	background-color:#fff;
}
caption{
	font-size:28px;
	margin-bottom:15px;
}
table{
	border:1px solid #333;
	border-collapse:collapse;
	margin:0 auto;
	width:740px;
}
td, tr, th{
	padding:12px;
	border:1px solid #333;
	width:185px;
}
th{
	background-color: #f0f0f0;
}
h4, p{
	margin:0px;
}
</style>


<body>

<div class="card text-center" style="margin-bottom:50px;">
  <h1>Add Items</h1>
</div>
  
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="form-group">
                    <form name="add_items" id="add_items">
                         <div class="print_area" id="print_area">
                        <table class="table table-bordered table-hover" id="invorce">
                            <thead>
                            <tr>
                                <td>
                                    <input type="text" required name="name[]" placeholder="Enter Item Name" id="name" class="form-control item_name" /></td>
                                 <td><input type="number" oninput="Total_amount(1)"  id="price1" required name="price[]"  placeholder="Enter Item Price" class="form-control item_price"/></td>
                                    
                                
                                <td><input type="number"  oninput="Total_amount(1)" required name="quantity[]" id="qty1"  placeholder="Enter Item Quantity" class="form-control item_quantity"/></td>
                               
                                <td><select name="tax[]" required id="tax1" class="form-control item_tax" onchange="Total_amount(1)">
                                        <option value="0">0%</option>
                                        <option value=".01">1%</option>
                                        <option value=".05">5%</option>
                                        <option value=".10">10%</option>
                                    </select></td>
                                     <td><input type="hidden"  name="total1[]" readonly id="total1"  placeholder="Total Amount" class="form-control total" />
                                     <input type="text" required name="total[]" readonly id="total_with_tax1"  placeholder="Total Amount" class="form-control total_with_tax" />
                                     </td>
                                <td><button type="button" name="add_more" id="add_more" class="btn btn-primary">Add More</button></td>  
                              
    
                            </tr>
                            </thead>
                            <tfoot>
                                   
            <tr>
               <td colspan="2" style="text-align: right;vertical-align: middle;">Sub Total With out Tax</td>
                  <td><input type="text" required name="subtotal_without_tax" readonly id="sub"  placeholder="Sub Total Without Tax" class="form-control total" /></td>
                  
               <td colspan="2" style="text-align: right;vertical-align: middle;">Sub Total With Tax</td>
                  <td><input type="text" required name="subtotal_withtax" readonly id="sub_tax"  placeholder="Sub Total with Tax" class="form-control total" /></td>
            </tr>
         
              <tr>
                <td></td>
                <td></td>
                 <td></td>  
                 <td colspan="2"style="text-align: right;vertical-align: middle;">Discount &nbsp;&nbsp;
                     <select class="form-control discountType" onchange="get_grandTotal()" name="discount_type"  id="discountType" style="width: 120px;display: inline-block;" > 
                         <option value="%">Percentage</option>
                     <option value="$">Amount</option></select></td>
                  <td><input type="text" required name="discount"  id="discount" oninput="get_grandTotal()"  placeholder="Discount" class="form-control discount" /></td>
            </tr>
               <tr>
                <td></td>
                <td></td>
                 <td></td>  
                 <td colspan="2" style="text-align: right;vertical-align: middle;" >Total</td>
                  <td><input type="text" required name="grandTotal" readonly id="grandTotal"  placeholder=" Total" class="form-control" /></td>
            </tr>
        </tfoot>
                                     </table>
                         </div>
                        <input type="button" class="btn btn-success"  name="submit" id="submit" value="Generate Invoice">
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
<?php
$invoice_details = $conn->query("SELECT * FROM invoice_item_details");
if($invoice_details->num_rows > 0){
			          while($in_row = $invoice_details->fetch_array()){
                        
			          ?>
       


<div class="invoice_container">
   
	<table class="invoice_generate">
		
		
		<tbody>
			<tr>
				<th>Name</th>
				<th>Price</th>
				<th>Qty</th>
				<th>Tax</th>
                                <th>Total</th>
			</tr>
                       <?php $invoicedetails = $conn->query("SELECT * FROM invoice_line_items where fk_invoice_id =".$in_row['invoice_id']);
                       foreach($invoicedetails as $list){
                          
                           //echo '<pre>';print_r($list);
                       ?>
			<tr>
				<td><?php echo $list['inv_li_name'] ?></td>
				<td><?php echo $list['inv_li_price'] ?></td>
				<td><?php echo $list['inv_li_quantity'] ?></td>
				<td><?php echo $list['inv_li_tax'] ?></td>
                                <td><?php echo $list['inv_li_price']*$list['inv_li_quantity']?></td>
			</tr>
                       <?php }?>
			
			<tr>
				<th colspan="4">Subtotal With Tax</th>
				<td><?php echo $in_row['sub_with_tax'] ?></td>
			</tr>
                        <tr>
				<th colspan="4">Subtotal Without Tax</th>
				<td><?php echo $in_row['sub_without_tax'] ?></td>
			</tr>
			<tr>
				<th>Discount</th>
				<td><?php echo $in_row['discount'] ?></td>
				
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="4">Grand Total</th>
				<td><?php echo $in_row['grand_total'] ?></td>
			</tr>
		</tfoot>
	</table>
</div>
                        <?php }} ?>                              
</body>
</html>

