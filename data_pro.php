<?php
header('Content-Type: application/json');
include('include/config.php');

// ทำการเชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($host, $username, $password, $database);

// เช็คการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// เตรียมคำสั่ง SQL เพื่อดึงข้อมูล
$sqlQuery = "SELECT 
            SUM(CASE WHEN Kg_Rice_bran != 0 THEN 1 ELSE 0 END) AS countbran,
            SUM(CASE WHEN Kg_Husk != 0 THEN 1 ELSE 0 END) AS counthusk,
            SUM(CASE WHEN Kg_Rice_chunks != 0 THEN 1 ELSE 0 END) AS countchunks,
            SUM(CASE WHEN Kg_Broken_rice != 0 THEN 1 ELSE 0 END) AS countbroken
            FROM 
            orderproduct";

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