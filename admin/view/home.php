<?php
require_once '../dao/pdo.php';
require_once '../dao/orders.php';
require_once '../dao/products.php';

// Hàm lấy tổng số sản phẩm
function get_total_products() {
    $sql = "SELECT COUNT(*) FROM products";
    return pdo_query_value($sql);
}

// Hàm lấy tổng số đơn hàng
function get_total_orders() {
    $sql = "SELECT COUNT(*) FROM orders";
    return pdo_query_value($sql);
}

// Hàm lấy tổng số người dùng
function get_total_users() {
    $sql = "SELECT COUNT(*) FROM users";
    return pdo_query_value($sql);
}

// Hàm lấy tổng số khách VIP
function get_total_vip_users() {
    $sql = "SELECT COUNT(*) FROM users WHERE is_vip = 1";
    return pdo_query_value($sql);
}

// Hàm lấy doanh thu hôm nay
function get_daily_revenue() {
    $sql = "SELECT SUM(total_amount) FROM orders WHERE DATE(order_date) = CURDATE() AND status = 'delivered'";
    return pdo_query_value($sql) ?? 0;
}

// Hàm lấy xu hướng doanh thu (7 ngày qua)
function get_revenue_trend() {
    $sql = "SELECT DATE(order_date) as date, SUM(total_amount) as total
            FROM orders 
            WHERE order_date >= CURDATE() - INTERVAL 7 DAY AND status = 'delivered'
            GROUP BY DATE(order_date)
            ORDER BY DATE(order_date)";
    return pdo_query($sql);
}

// Hàm lấy 5 đơn hàng gần đây
function get_recent_orders() {
    $sql = "SELECT order_id, order_code, customer_name, total_amount, order_date, status 
            FROM orders 
            ORDER BY order_date DESC 
            LIMIT 5";
    return pdo_query($sql);
}

$total_products = get_total_products();
$total_orders = get_total_orders();
$total_users = get_total_users();
$total_vip_users = get_total_vip_users();
$daily_revenue = get_daily_revenue();
$revenue_trend = get_revenue_trend();
$recent_orders = get_recent_orders();

// Chuẩn bị dữ liệu cho Chart.js
$dates = [];
$revenues = [];
foreach ($revenue_trend as $row) {
    $dates[] = date('M d', strtotime($row['date']));
    $revenues[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Điều Khiển Quản Trị</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .highlight-info li {
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .highlight-info li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <!-- Header -->
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tổng quan</h1>
            <img class="w-10 h-10" src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Account Icon">
        </header>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="card bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Sản phẩm</h3>
                <p class="text-2xl font-bold text-blue-600"><?php echo $total_products; ?></p>
            </div>
            <div class="card bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Đơn hàng</h3>
                <p class="text-2xl font-bold text-green-600"><?php echo $total_orders; ?></p>
            </div>
            <div class="card bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Người dùng</h3>
                <p class="text-2xl font-bold text-purple-600"><?php echo $total_users; ?></p>
            </div>
            <div class="card bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Khách VIP</h3>
                <p class="text-2xl font-bold text-yellow-600"><?php echo $total_vip_users; ?></p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Xu hướng doanh thu (7 ngày qua)</h3>
            <canvas id="myChart" width="400" height="150"></canvas>
        </div>

        <!-- Info and Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Highlight Info -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin nổi bật</h3>
                <ul class="highlight-info text-gray-600">
                    <li>Sản phẩm bán chạy nhất: <?php
                        $best_selling = get_bestselling(1);
                        echo !empty($best_selling) ? htmlspecialchars($best_selling[0]['name']) : 'Chưa có dữ liệu';
                    ?></li>
                    <li>Doanh thu hôm nay: $<?php echo number_format($daily_revenue, 2); ?></li>
                    <li>Khách hàng mới: <?php
                        $sql = "SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()";
                        echo pdo_query_value($sql);
                    ?></li>
                    <li>Đơn hàng chờ xử lý: <?php
                        $sql = "SELECT COUNT(*) FROM orders WHERE status = 'pending'";
                        echo pdo_query_value($sql);
                    ?></li>
                </ul>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Đơn hàng gần đây</h3>
                <table class="w-full text-left text-gray-600">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Mã đơn</th>
                            <th class="py-2">Khách hàng</th>
                            <th class="py-2">Tổng tiền</th>
                            <th class="py-2">Ngày đặt</th>
                            <th class="py-2">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2"><?php echo htmlspecialchars($order['order_code']); ?></td>
                                <td class="py-2"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td class="py-2">$<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td class="py-2"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-sm <?php
                                        echo $order['status'] == 'delivered' ? 'bg-green-200 text-green-800' :
                                            ($order['status'] == 'pending' ? 'bg-yellow-200 text-yellow-800' :
                                            ($order['status'] == 'cancelled' ? 'bg-red-200 text-red-800' : 'bg-blue-200 text-blue-800'));
                                    ?>">
                                        <?php
                                        // Ánh xạ trạng thái sang tiếng Việt
                                        $status_map = [
                                            'pending' => 'Chờ xử lý',
                                            'processing' => 'Đang xử lý',
                                            'shipped' => 'Đã giao',
                                            'delivered' => 'Đã giao hàng',
                                            'cancelled' => 'Đã hủy'
                                        ];
                                        echo htmlspecialchars($status_map[$order['status']]);
                                        ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'Doanh thu ($)',
                    data: <?php echo json_encode($revenues); ?>,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu ($)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Ngày'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>
</html>