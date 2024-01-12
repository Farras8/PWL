<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=products.xls");
require '../config/function.php';  // Include your database connection file

// Fetch products data
$products = mysqli_query($conn, "SELECT products.*, categories.name AS category_name
                                    FROM products
                                    JOIN categories ON products.category_id = categories.id");

// Set headers for download
?>

<table border="1" cellpadding="5">
  <tr>
    <th>ID</th>
    <th>Category Name</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Quantity</th>
  </tr>
  <?php 
  $i = 1;
  while ($row = mysqli_fetch_array($products)) { ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $row['category_name']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['description']; ?></td>
      <td><?php echo $row['price']; ?></td>
      <td><?php echo $row['quantity']; ?></td>
    </tr>
  <?php } ?>
</table>


