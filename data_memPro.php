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
                  m.Member_Id,
                  m.Member_Name,
                  COUNT(op.OrderProduct_Id) AS Total_Order_Count,
                  SUM(op.Total_Product) AS Total_Weight_Purchased
            FROM 
                  member m
            LEFT JOIN 
                  orderproduct op ON m.Member_Id = op.Member_Id
            GROUP BY 
                  m.Member_Id, m.Member_Name
            ORDER BY 
                  Total_Order_Count DESC

            ";

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