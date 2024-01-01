<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Create Order
            </h4>
        </div>
        <div class="card-body">
            <?php alert(); ?>
            <form action="orders-code.php" method="post">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="">Select Product</label>
                        <select name="product_id" class="form-select mySelect2">
                            <option value="">--Select Product--</option>
                            <?php
                            $products = getALL('products');
                            if ($products) {
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $prodItem) {
                            ?>
                                        <option value="<?= $prodItem['id']; ?>"><?= $prodItem['name']; ?></option>
                            <?php
                                    }
                                } else {
                                    echo '<option valu="">No Product found </option>';
                                }
                            } else {
                                echo '<option valu="">Something Went Wrong </option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" required class="form-control" />
                    </div>
                    <div class="col-md-3 mb-3 text-end">
                        <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Products</h4>
        </div>
        <div class="card-body">
            <?php
            if (isset($_SESSION['productItems'])) {
                $sessionProducts = $_SESSION['productItems'];
                if (empty($sessionProducts)) {
                    unset($_SESSION['productItemIds']);
                    unset($_SESSION['productItems']);
                }
            ?>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($sessionProducts as $key => $item) :
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $item['name']; ?></td>
                                    <td><?= $item['price']; ?></td>
                                    <td>
                                        <div class="input-group qtyBox">
                                            <input type="hidden" value="<?= $item['product_id'] ?>" class="prodId">
                                            <button class="input-group-text decrement">-</button>
                                            <input type="text" value="<?= $item['quantity']; ?>" class="qty quantityInput" />
                                            <button class="input-group-text increment">+</button>
                                        </div>
                                    </td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 0); ?></td>
                                    <td>
                                        <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Select Payment Mode</label>
                            <select id="payment_mode" class="form-select">
                                <option value="">-- Select Payment --</option>
                                <option value="Cash Payment">Cash Payment</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Enter Customer Name</label>
                            <input type="text" id="cName" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <br />
                            <button type="button" class="btn btn-warning w-100 proceed">Proceed to place order</button>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                echo '<h5>No Items addes</h5>';
            }
            ?>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>