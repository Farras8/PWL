<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
                <a href="export.php" class="btn btn-danger float-end " style="margin-right: 10px;">export</a>
                <a href="form.php" class="btn btn-warning float-end" style="margin-right: 10px;">import</a>
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
                <div class="table-responsive" >
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
                            
                            <?php
                            $i = 1;
                             foreach ($products as $row) : ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td>
                                        <a href="products-edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="products-delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want delete this data.')">Delete</a>
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