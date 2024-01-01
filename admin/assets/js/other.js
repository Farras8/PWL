$(document).ready(function () {

    $(document).on('click', '.increment', function () {

        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val());

        if (!isNaN(currentValue)) {
            var qtyVal = currentValue + 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);
        }
    });

    $(document).on('click', '.decrement', function () {

        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val());

        if (!isNaN(currentValue) && currentValue > 1) {
            var qtyVal = currentValue - 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);
        }
    });

    function quantityIncDec(prodId, qty) {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'productIncDec': true,
                'product_id': prodId,
                'quantity': qty
            },
            success: function (response) {
                var res = JSON.parse(response);

                if (res.status == 200) {
                    window.location.reload();
                    alertify.success(res.message);
                } else {
                    alertify.error(res.message);
                }
            }
        })
    }

    $(document).on('click', '.proceed', function () {

        console.log('proceed');

        var cName = $('#cName').val();
        var payment_mode = $('#payment_mode').val();

        if (payment_mode == '') {
            swal("Select Payment Mode", "Select your payment payment_mode", "warning");
            return false;
        }

        if (cName == '') {
            swal("Enter Customer Name", "Enter Customer Name","warning");
            return false;
        }


        var data = {
            'proceedToPlaceBtn' : true,
            'cName': cName,
            'payment_mode': payment_mode,
        }
        $.ajax({
            type:"POST",
            url: "orders-code.php",
            data: data,
            success: function(respons){

                    // Redirect to orders-summary.php
                    window.location.href = "order-summary.php";
                
            }
        });
        

    });

    $(document).on('click', '.saveOrder', function(){
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'saveOrder': true
            },
            success: function(response){
                var res = JSON.parse(response);
                
                if(res.status == 200){
                    swal(res.message, res.message, res.status_type);
                    $('#OrderPlaceSuccessMessage').text(res.message);
                    $('#OrderSuccessModal').modal('show');
                }else{
                    swal(res.message, res.message, res.status_type);
                }
            }
        })
    })

});

function printMyBillingArea(){

    var divContents = document.getElementById("myBillingArea").innerHTML;
    var a = window.open('','');
    a.document.write('<html><title>IVASTA</title>');
    a.document.write('<body style="font-family: fangsong;">');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
}

