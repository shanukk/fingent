<?php
include 'db_connect.php';


$itemcount= count($_POST['name']);	
	if ($itemcount > 0) {
            $grandtotal=$_POST['grandTotal']?$_POST['grandTotal']:0;
            $sub_without_tax=$_POST['subtotal_without_tax'];
            $sub_with_tax=$_POST['subtotal_withtax'];
            $discounttype=$_POST['discount_type'];
            $discount=$_POST['discount'].''.$discounttype?$_POST['discount'].''.$discounttype:0;
            
            
            $add_details="INSERT INTO invoice_item_details (grand_total,sub_with_tax,sub_without_tax,discount) VALUES ($grandtotal,$sub_with_tax,$sub_without_tax,'$discount')";
            $conn->query($add_details);
            $last_insert_id=$conn->insert_id;
	    for ($i=0; $i < $itemcount; $i++) { 
		if (trim($_POST['name'] != '') && trim($_POST['price'] != '')&& trim($_POST['quantity'] != '')&& trim($_POST['tax'] != '')) {
			$name   = $_POST["name"][$i];
			$price  = $_POST["price"][$i];
                        $quantity  = $_POST["quantity"][$i];
                        $tax  = $_POST["tax"][$i];
			$sql  = "INSERT INTO invoice_line_items (inv_li_name,inv_li_price,inv_li_tax,inv_li_quantity,fk_invoice_id) VALUES ('$name','$price','$tax',$quantity,$last_insert_id)";
                        if ($conn->query($sql) === TRUE) {
                          echo "New record created successfully";
                              } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                            }
			
		}
	    }
        }
            
            
	
?>


