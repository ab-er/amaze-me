<?php
// process_payment.php

$host = "localhost"; // اسم الخادم
$dbname = "car_rental"; // اسم قاعدة البيانات
$username = "root"; // اسم المستخدم لقاعدة البيانات
$password = ""; // كلمة المرور لقاعدة البيانات

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جلب البيانات من النموذج
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cardholder_name = $_POST['cardholder_name'];
    $cvv = $_POST['cvv'];

    // التحقق من عدم وجود الحقول فارغة
    if (!empty($card_number) && !empty($expiry_date) && !empty($cardholder_name) && !empty($cvv)) {
        // إدراج تفاصيل الدفع في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO payments (card_number, expiry_date, cardholder_name, cvv) VALUES (:card_number, :expiry_date, :cardholder_name, :cvv)");
        $stmt->bindParam(':card_number', $card_number);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $stmt->bindParam(':cardholder_name', $cardholder_name);
        $stmt->bindParam(':cvv', $cvv);

        if ($stmt->execute()) {
            echo "تم الدفع بنجاح!";
        } else {
            echo "حدث خطأ أثناء إجراء الدفع.";
        }
    } else {
        echo "الرجاء ملء جميع الحقول.";
    }
}
?>
