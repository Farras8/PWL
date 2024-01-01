<?php
include('includes/header.php');
?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0">Orders</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php
            $query = "SELECT * FROM orders ";
            $orders = mysqli_query($conn, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
            ?>
                    <table class="table table-striped table-bordered align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Payment Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem) : ?>
                                <tr>
                                    <td class="fw-bold"><?= $orderItem['invoice_no'] ?></td>
                                    <td class="fw-bold"><?= $orderItem['customer_name'] ?></td>
                                    <td class="fw-bold"><?= date('d M, Y', strtotime($orderItem['order_date'])) ?></td>
                                    <td class="fw-bold"><?= $orderItem['payment_method'] ?></td>
                                    <td>
                                        <a href="orders-view.php?inv=<?= $orderItem['invoice_no']; ?>" class="btn btn-info mb-0 px-2 btn-sm">View</a>
                                        <a href="orders-print.php?inv=<?= $orderItem['invoice_no']; ?>" class="btn btn-primary mb-0 px-2 btn-sm">Print</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
            <?php
                } else {
                    echo '<h5>No Orders Found</h5>';
                }
            } else {
                echo '<h5>Something Went Wrong</h5>';
            }
            ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>