<?php
include('includes/header.php');
?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Order View</h4>
            <a href="orders-print.php?inv=<?= $_GET['inv'] ?>" class="btn btn-primary mx-2 btn-sm float-end">Print</a>
            <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alert(); ?>

            <?php
            if (isset($_GET['inv'])) {
                if($_GET['inv'] == ''){
                    ?>
                    <div class="text-center py-5">
                        <h5>No Invoice Found</h5>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                    </div>
                    <?php
                    return false;
                }
                $InvoiceNo = validate($_GET['inv']);
                $query = "SELECT * FROM orders  ";
                $orders = mysqli_query($conn, $query);
                if ($orders) {
                    if (mysqli_num_rows($orders) > 0) {
                        $orderData = mysqli_fetch_assoc($orders);
                        $orderId = $orderData['id'];
            ?>
                        <div class="card card-body shadow border-1 mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Order Details</h4>
                                    <label class="mb-1">
                                        Invoice No: <span class="fw-bold"><?= $orderData['invoice_no']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Order Date: <span class="fw-bold"><?= $orderData['order_date']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Payment Mode: <span class="fw-bold"><?= $orderData['payment_method']; ?></span>
                                    </label>
                                    <br />
                                </div>
                                <div class="col-md-6">
                                    <h4>Customer</h4>
                                    <label class="mb-1">
                                        Customer Name: <span class="fw-bold"><?= $orderData['customer_name']; ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <?php
                        $orderItemQuery = "SELECT p.name as productName, oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* FROM orders as o, order_items as oi, products as p 
                        WHERE oi.order_id = o.id AND p.id = oi.product_id AND o.invoice_no='$InvoiceNo'";
                        $orderItemRes = mysqli_query($conn, $orderItemQuery);
                        if ($orderItemRes) {
                            if (mysqli_num_rows($orderItemRes) > 0) {
                        ?>
                                <h4 class="my-3">Order Item Details</h4>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orderItemRes as $orderItemRow) : ?>
                                            <tr>
                                                <td width="15%" class="fw-bold text-center">
                                                    <?= $orderItemRow['productName'] ?>
                                                </td>
                                                <td width="15%" class="fw-bold text-center">
                                                    <?= number_format($orderItemRow['orderItemPrice'],0) ?>
                                                </td>
                                                <td width="15%" class="fw-bold text-center">
                                                    <?= $orderItemRow['orderItemQuantity'] ?>
                                                </td>
                                                <td width="15%" class="fw-bold text-center">
                                                    <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity'],0) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td class="text=end fw-bold">Total Price: </td>
                                            <td colspan="3" class="text-end fw-bold"><?= number_format($orderItemRow['total_Amount'],0); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                        <?php
                            } else {
                                echo '<h5>Something Went Wrong</h5>';
                                return false;
                            }
                        } else {
                            echo '<h5>Something Went Wrong</h5>';
                            return false;
                        }
                        ?>
            <?php
                    } else {
                        echo '<h5>No Record Found</h5>';
                        return false;
                    }
                }
            } else {
                ?>
                <div class="text-center py-5">
                    <h5>No Invoice Number Found</h5>
                    <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>