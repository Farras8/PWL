<?php

include('../config/function.php');

if (isset($_POST['saveAdmin'])) {

    $name = validate($_POST['name']);
    $password = validate($_POST['password']);

    $existingAdmin = getByColumn('admins', 'name', $name);
    if (count($existingAdmin) > 0) {
        redirect('admins-create.php', 'Admin with the same name already exists.');
    }
    if ($name != '' && $password != '') {

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'password' => $password,
        ];
        $result = insert('admins', $data);

        if ($result) {
            redirect('admins.php', 'Create Admin Success');
        } else {
            redirect('admins-create.php', 'Create Admin Fail');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields.');
    }
}
if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields.');
    }
    $name = validate($_POST['name']);
    $password = validate($_POST['password']);

    $existingAdmin = getByColumn('admins', 'name', $name);
    if (count($existingAdmin) > 0) {
        $existingAdminId = $existingAdmin[0]['id'];
        if ($existingAdminId != $adminId) {
            redirect('admins-edit.php?id=' . $adminId, 'Admin with the same name already exists.');
        }
    }

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }
    if ($name != ''  && $password != '') {
        $data = [
            'name' => $name,
            'password' => $password,
        ];
        $result = update('admins', $adminId, $data);

        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Update Admin Success');
        } else {
            redirect('admins-create.php', 'Create Admin Fail');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields.');
    }
}

if (isset($_POST['saveCategory'])) {

    $name = validate($_POST['name']);

    $existingCategory = getByColumn('categories', 'name', $name);
    if (count($existingCategory) > 0) {
        redirect('categories-create.php', 'Category with the same name already exists.');
    }

    $data = [
        'name' => $name,
    ];
    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'Create Category Success');
    } else {
        redirect('categories-create.php', 'Create Category Fail');
    }
}

if (isset($_POST['updateCategory'])) {
    $category_id = validate($_POST['category_id']);


    $name = validate($_POST['name']);

    $existingCategory = getByColumn('categories', 'name', $name);
    if (count($existingCategory) > 0) {
        $existingCategoryId = $existingCategory[0]['id'];
        if ($existingCategoryId != $category_id) {
            redirect('categories-edit.php?id=' . $category_id, 'Category with the same name already exists.');
        }
    }

    $data = [
        'name' => $name,
    ];
    $result = update('categories', $category_id, $data);

    if ($result) {
        redirect('categories-edit.php?id=' . $category_id, 'update Category Success');
    } else {
        redirect('categories-edit.php?id=' . $category_id, 'update Category Fail');
    }
}
if (isset($_POST['saveProduct'])) {

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);

    $existingProduct = getByColumn('products', 'name', $name);
    if (count($existingProduct) > 0) {
        redirect('products-create.php', 'Product with the same name already exists.');
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity
    ];
    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Create Product Success');
    } else {
        redirect('products-create.php', 'Create Product Fail');
    }
}

if (isset($_POST['updateProduct'])) {
    $product_id = validate($_POST['product_id']);

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);

    $existingProduct = getByColumn('products', 'name', $name);
    if (count($existingProduct) > 0) {
        $existingProductId = $existingProduct[0]['id'];
        if ($existingProductId != $product_id) {
            redirect('products-edit.php?id=' . $product_id, 'Product with the same name already exists.');
        }
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity
    ];
    $result = update('products', $product_id, $data);

    if ($result) {
        redirect('products-edit.php?id=' . $product_id, 'update Product Success');
    } else {
        redirect('products-edit.php?id=' . $product_id, 'update Product Fail');
    }
}
