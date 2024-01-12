<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Category
                <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
                <a href="exportCategories.php" class="btn btn-danger float-end " style="margin-right: 10px;">export</a>
                <a href="formCategories.php" class="btn btn-warning float-end" style="margin-right: 10px;">import</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alert(); ?>

            <?php

            $categories = getAll('categories');
            if (mysqli_num_rows($categories) > 0) {
            ?>
                <div class="table-responsive">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($categories as $Item) : 
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $Item['name'] ?></td>
                                    <td>
                                        <a href="categories-edit.php?id=<?= $Item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="categories-delete.php?id=<?= $Item['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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