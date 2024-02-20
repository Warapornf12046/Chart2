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
if(isset($_POST['year'])) {
    $year = $_POST['year'];
    $month = $_POST['month']; // เพิ่มการรับค่าเดือน
} else {
    // ถ้าไม่ได้รับค่าปีให้ใช้ปีและเดือนปัจจุบัน
    $year = date("Y");
    $month = date("m");
}

// เตรียมคำสั่ง SQL เพื่อดึงข้อมูล
$sqlQuery = "SELECT sp.ServiceProduct_Name, COUNT(op.ServiceProduct_Id) AS Total_Order
            FROM orderproduct op
            INNER JOIN serviceandproduct sp ON op.ServiceProduct_Id = sp.ServiceProduct_Id
            WHERE YEAR(op.OrderProduct_Date) = $year AND MONTH(op.OrderProduct_Date) = $month
            GROUP BY op.ServiceProduct_Id";


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
