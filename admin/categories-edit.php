<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Product
                <a href="categories.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alert(); ?>
            <form action="code.php" method="post">
                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not an interger</h5>';
                    return false;
                }

                $category = getById('categories', $paramValue);
                if ($category) {

                    if ($category['status'] == 200) {
                ?>
                        <input type="hidden" name="category_id" required value="<?= $category['data']['id']; ?>" />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Name *</label>
                                <input type="text" name="name" required value="<?= $category['data']['name']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateCategory" class="btn btn-warning">Update</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $product['message'] . '</h5>';
                    }
                } else {
                    echo '<h5>Something Went Wrong</h5>';
                    return false;
                }
                ?>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>