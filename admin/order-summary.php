<?php
include('includes/header.php');
if (!isset($_SESSION['productItems'])) {
    echo '<script> window.location.href = "order-create.php"; </script>';
};

// Retrieve payment mode, customer name, and invoice number from session
$payment_mode = isset($_SESSION['payment_mode']) ? $_SESSION['payment_mode'] : '';
$cName = isset($_SESSION['cName']) ? $_SESSION['cName'] : '';
$invoiceNumber = isset($_SESSION['invoice_number']) ? $_SESSION['invoice_number'] : '';

?>
<div class="modal fade" id="OrderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3">
                    <h5 id="OrderPlaceSuccessMessage"></h5>
                </div>
                <a href="orders.php" class="btn btn-secondary">Close</a>
                <button type="button" onclick="printMyBillingArea()" class="btn btn-danger">Print</button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        Order Summary
                        <a href="order-create.php" class="btn btn-danger float-end">Back To Create Order</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php alert(); ?>
                    <div id="myBillingArea">
                        <table style="width: 100%; margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <td style="text-align:center;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin:2px; padding: 0;">IVASTA</h4>
                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">Jl.Ivander No.13, Kec.Rumah, Jakarta Tenggara</p>
                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">Ivasta put Itd.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Customer</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Name: <?= $cName ?> </p>
                                    </td>
                                    <td align="end">
                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Invoice Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice No: <?= $invoiceNumber ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice Date: <?= date('Y-m-d') ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <?php
                        if (isset($_SESSION['productItems'])) {
                            $sessionProducts = $_SESSION['productItems'];
                        ?>
                            <div class="table-responsive mb-3">
                                <table style="width: 100%;" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #acc;" width="5%">ID</th>
                                            <th align="start" style="border-bottom: 1px solid #acc;">Product Name</th>
                                            <th align="start" style="border-bottom: 1px solid #acc;" width="10%">Price</th>
                                            <th align="start" style="border-bottom: 1px solid #acc;" width="10%">Quantity</th>
                                            <th align="start" style="border-bottom: 1px solid #acc;" width="15%">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $totalAmount = 0;
                                        foreach ($sessionProducts as $key => $row) :
                                            $totalAmount += $row['price'] * $row['quantity']
                                        ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++ ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['price'], 0) ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['quantity'] ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold"><?= number_format($row['price'] * $row['quantity'], 0) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Grand Total:</td>
                                            <td colspan="1" style="font-weight: bold;"><?= number_format($totalAmount, 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Payment Mode: <?= $payment_mode ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo '<h5 class"text-center">No Item addded</h5>';
                        }
                        ?>
                    </div>
                    <div>
                        <?php
                        if (isset($_SESSION['productItems'])) :
                        ?>
                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-primary px-4 mx-1 saveOrder">Save</button>
                            </div>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>