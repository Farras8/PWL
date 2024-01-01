<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alert(); ?>

            <?php

            $products = mysqli_query($conn, "SELECT products.*, categories.name AS category_name
            FROM products
            JOIN categories ON products.category_id = categories.id");
            if (mysqli_num_rows($products) > 0) {
            ?>
                <div class="table-responsive">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Name</th>
                                <th>description</th>
                                <th>price</th>
                                <th>quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $Item) : ?>
                                <tr>
                                    <td><?= $Item['id'] ?></td>
                                    <td><?= $Item['category_name'] ?></td>
                                    <td><?= $Item['name'] ?></td>
                                    <td><?= $Item['description'] ?></td>
                                    <td><?= $Item['price'] ?></td>
                                    <td><?= $Item['quantity'] ?></td>
                                    <td>
                                        <a href="products-edit.php?id=<?= $Item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="products-delete.php?id=<?= $Item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want delete this data.')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>
                <h4 class="mb-0">No Record Found</h4>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>