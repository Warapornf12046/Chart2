<?php
header('Content-Type: application/json');
include('include/config.php');

// ทำการเชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($host, $username, $password, $database);

// เช็คการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่าปีและเดือนที่ส่งมาจาก JavaScript
if(isset($_POST['year']) && isset($_POST['month'])) {
    $year = $_POST['year'];
    $month = $_POST['month'];
} else {
    // ถ้าไม่ได้รับค่าปีและเดือนให้ใช้ปีและเดือนปัจจุบัน
    $year = date("Y");
    $month = date("m");
}

// เตรียมคำสั่ง SQL เพื่อดึงข้อมูล
$sqlQuery = "SELECT
                sp.ServiceProduct_Name,
                COUNT(os.OrderService_Id) AS Usage_Count
            FROM
                orderservice os
            INNER JOIN serviceandproduct sp ON os.ServiceProduct_Id = sp.ServiceProduct_Id
            WHERE YEAR(os.OrderService_Date) = $year AND MONTH(os.OrderService_Date) = $month
            GROUP BY
                sp.ServiceProduct_Name";

// ทำการส่งคำสั่ง SQL ไปที่ฐานข้อมูล
$result = mysqli_query($conn, $sqlQuery);

// ตรวจสอบว่ามีข้อมูลที่ได้รับหรือไม่
if (mysqli_num_rows($result) > 0) {
    // สร้างตัวแปร array เพื่อเก็บข้อมูล
    $data = array();
    // วนลูปเพื่อดึงข้อมูลและเก็บไว้ในตัวแปร $data
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);
    // แสดงผลลัพธ์เป็น JSON
    echo json_encode($data);
} else {
    // ถ้าไม่มีข้อมูลในฐานข้อมูล
    echo "No data found.";
}
?>
