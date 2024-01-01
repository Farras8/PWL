<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
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

                $product = getById('products', $paramValue);
                if ($product) {

                    if ($product['status'] == 200) {
                ?>
                        <input type="hidden" name="product_id" required value="<?= $product['data']['id']; ?>" />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Select Category</label>
                                <select name="category_id" id="form-select">
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = getALL('categories');
                                    if ($categories) {
                                        if (mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $category) {
                                    ?>

                                                <option value="<?= $category['id']; ?>" <?= $product['data']['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                                    <?= $category['name']; ?>
                                                </option>

                                    <?php
                                            }
                                        } else {
                                            echo '<option value="">No Categories Found </option>';
                                        }
                                    } else {
                                        echo '<option value="">Something Went Wrong </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Product Name *</label>
                                <input type="text" name="name" required value="<?= $product['data']['name']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Description *</label>
                                <input type="text" name="description" required value="<?= $product['data']['description']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Price *</label>
                                <input type="number" name="price" required value="<?= $product['data']['price']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Quantity *</label>
                                <input type="number" name="quantity" required value="<?= $product['data']['quantity']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateProduct" class="btn btn-warning">Update</button>
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