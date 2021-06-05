
$(function(){

var i = 1;
        $("#add_more").click(function(){

i++;
        $('#invorce').append(' <thead><tr id="row' + i + '">\n\
        <td><input type="text" name="name[]" placeholder="Enter Item Name" class="form-control item_name"/></td>\n\
        <td><input type="number" name="price[]" id="price' + i + '" oninput="Total_amount(' + i + ')" placeholder="Enter Item Price" class="form-control item_price"/></td>\n\
       <td><input type="number" id="qty' + i + '" name="quantity[]" oninput="Total_amount(' + i + ')" placeholder="Enter Item Quantity" class="form-control item_quantity"/></td>\n\
      <td><select name="tax[]" id="tax' + i + '" onchange="Total_amount(' + i + ')" class="form-control item_tax"><option value="0">0%</option> <option value=".01">1%</option> <option value=".05">5%</option> <option value=".10">10%</option></select></td>\n\\n\
     <td><input type="hidden" required name="total[]" readonly id="total' + i + '"  placeholder="Total Amount" class="form-control total" />\n\
<input type="text" required name="total_with_tax[]" readonly id="total_with_tax' + i + '"  placeholder="Total Amount" class="form-control total_with_tax" /></td>\n\
        <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr> </thead>');
});
        $(document).on('click', '.btn_remove', function(){
var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
        Get_Subtotal();
});
        $("#submit").on('click', function(){
var name = $("#name").val();
        var itemsdata = $("#add_items").serialize();
        $.ajax({
        type: 'POST',
                url: 'add_more_items.php',
                data: itemsdata,
                //dataType: 'json',
                cache :false,
                success:function(result){
                if (result.error){
                alert("error");
                }
                else {
                alert(result);
                        $("#add_items")[0].reset();
                        location.reload();
                }
                // alert(result);
                // $("#add_name")[0].reset();
                }, error : function(err) {
        alert(err);
        }
        });
});
        $('.item_tax').on('change', function() {
Get_Subtotal();
        });
});
        function Total_amount(rowid)
                {

                var price = $("#price" + rowid).val();
                        var qty = $("#qty" + rowid).val();
                        var tax = $("#tax" + rowid).val();
                        if (qty == ''){
                var qty = 1;
                }
                var total = price * qty;
                        var total_with_tax = total + (total * tax)
                        $("#total_with_tax" + rowid).val(total_with_tax);
                        $("#total" + rowid).val(total);
                        Get_Subtotal();
                        }

        function Get_Subtotal()
                {
                var subtotal = 0;
                        var subtotal_with_tax = 0;
                        //var total = 0;
                        $("#invorce > thead  > tr").each(function() {
//        var qty = $(this).find("#qty").val(); alert(qty);
//        var price = $(this).find("#price").val(); alert(price)
//        var amount = (qty*price)
                var total = $(this).find(".total").val();
                        var total_with_tax = $(this).find(".total_with_tax").val();
                        //  var taxtotal= $(this).find(".item_tax").val(); 
                        if (total != null && total.trim().length > 0) {
                subtotal = parseFloat(subtotal) + parseFloat(total);
                        subtotal_with_tax = parseFloat(subtotal_with_tax) + parseFloat(total_with_tax);
                        $("#sub").val(subtotal);
                        $("#sub_tax").val(subtotal_with_tax);
                }

                get_grandTotal();
                });
                        // $('.total').text(sum);
                        }
        function get_grandTotal()
                {
                var discountType = $('#discountType').val();
                        var discount = $('#discount').val();
                        var grandTotal = 0;
                        var sub_tax = $('#sub_tax').val();
                        if (discount != null && discount.trim().length > 0) {
                if (discountType == '%') {
                grandTotal = parseFloat(sub_tax) - (parseFloat(sub_tax) * parseFloat(discount) / 100);
                } else if (discountType == '$') {
                grandTotal = parseFloat(sub_tax) - parseFloat(discount);
                }
                else {
                grandTotal = parseFloat(sub_tax);
                }

                }
                else {
                grandTotal = parseFloat(sub_tax);
                }
                $('#grandTotal').val(grandTotal);
                        }
        function PrinrInvoice()
                {

                window.print();
                }

