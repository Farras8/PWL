<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=categories.xls");
require '../config/function.php';  // Include your database connection file

// Fetch products data
$categories = mysqli_query($conn, "SELECT * FROM categories");

// Set headers for download
?>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Category Name</th>
    </tr>
    <?php 
    $i = 1;
    while ($row = mysqli_fetch_array($categories)) { ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['name']; ?></td>
        </tr>
    <?php } ?>
</table>