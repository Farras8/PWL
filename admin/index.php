<?php include('includes/header.php'); ?>

<div class="container-fluid px-4" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Dashboard</h1>
            <?php alert() ?>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 " style="border: none;  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.6); background-color:#3f5bcc;">
                <p class="text-sm mb-0 text-capitalize">Total Category</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('categories') ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 bg-warning" style="border: none;  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.6);">
                <p class="text-sm mb-0 text-capitalize">Total Products</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('products') ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 bg-danger" style="border: none;  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.6); ">
                <p class="text-sm mb-0 text-capitalize">Total Admins</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('admins') ?>
                </h5>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
            <h5>Orders</h5>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3" style="border: none;  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.6); ">
                <p class="text-sm mb-0 text-capitalize">Today Orders</p>
                <h5 class="fw-bold mb-0">
                    <?php
                    $todayDate = date('Y-m-d');
                    $todayOrders = mysqli_query($conn, "SELECT * FROM orders WHERE order_date='$todayDate'");
                    if ($todayOrders) {
                        if (mysqli_num_rows($todayOrders) > 0) {
                            $totalCountOrders = mysqli_num_rows($todayOrders);
                            echo $totalCountOrders;
                        } else {
                            echo "0";
                        }
                    } else {
                        echo 'Something Went Wrong';
                    }
                    ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3" style="border: none;  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.6); ">
                <p class="text-sm mb-0 text-capitalize">Total Orders</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('orders') ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
        <h5>Pendapatan per Tanggal </h5>
    </div>
    <div class="row" >
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                <?php
                $chartDataDate = array();
                $startDate = date('Y-m-d', strtotime('-6 days')); // Ambil tanggal awal (7 hari sebelumnya)
                $endDate = date('Y-m-d'); // Ambil tanggal hari ini
                $incomeByDateQuery = mysqli_query($conn, "SELECT order_date, SUM(total_amount) as total_income FROM orders WHERE order_date BETWEEN '$startDate' AND '$endDate' GROUP BY order_date");

                while ($row = mysqli_fetch_assoc($incomeByDateQuery)) {
                    $orderDate = $row['order_date'];
                    $totalIncome = $row['total_income'];
                    $chartDataDate[] = array($orderDate, $totalIncome);
                }
                ?>

                var data = google.visualization.arrayToDataTable([
                    ['Date', 'Total Amount'],
                    <?php
                    foreach ($chartDataDate as $data) {
                        echo "['" . $data[0] . "', " . $data[1] . "],";
                    }
                    ?>
                ]);

                var options = {
                    chart: {
                        title: 'Pendapatan per Tanggal ',
                        subtitle: '',
                    }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material_7days'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>
        <div id="columnchart_material_7days" style="width: 2000px; height: 500px;"></div>
    </div>

    <div class="col-md-12">
        <hr>
        <h5>Product Sales</h5>
    </div>
    <div class="row">
        <?php
        $chartData = array();
        $orderItemsQuery = mysqli_query($conn, "SELECT product_id, SUM(quantity) as total_quantity FROM order_items GROUP BY product_id");

        while ($row = mysqli_fetch_assoc($orderItemsQuery)) {
            $productId = $row['product_id'];
            $totalQuantity = $row['total_quantity'];

            // Fetch product name from products table
            $productNameQuery = mysqli_query($conn, "SELECT name FROM products WHERE id = $productId");
            $productName = mysqli_fetch_assoc($productNameQuery)['name'];

            // Add data to chart array
            $chartData[] = array($productName, $totalQuantity);
        }
        ?>

        <script type="text/javascript">
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Product Name', 'Total Sales'],
                    <?php
                    foreach ($chartData as $data) {
                        echo "['" . $data[0] . "', " . $data[1] . "],";
                    }
                    ?>
                ]);

                var options = {
                    title: 'Product Sales',
                    is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
        </script>

        <div id="piechart_3d" style="width: 2000px; height: 500px;"></div>
    </div>
</div>




<?php include('includes/footer.php'); ?>