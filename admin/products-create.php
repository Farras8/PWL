<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Add Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alert(); ?>
            <form action="code.php" method="post">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Select Category</label>
                        <select name="category_id" id="form-select">
                            <option value="">Select Category</option>
                            <?php
                            $categories = getALL('categories');
                            if($categories){
                                if(mysqli_num_rows($categories) > 0 ){
                                    foreach($categories as $cateItem){
                                        echo '<option value="'.$cateItem['id'].'">'.$cateItem['name'].' </option>';
                                    }
                                }else{
                                    echo '<option value="">No Categories Found </option>';
                                }
                            }else{
                                echo '<option value="">Something Went Wrong </option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Product Name *</label>
                        <input type="text" name="name" required class="form-control"/>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description *</label>
                        <textarea name="description"  rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Price *</label>
                        <input type="text" name="price" required class="form-control"/>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Quantity *</label>
                        <input type="text" name="quantity" required class="form-control"/>
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveProduct" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>