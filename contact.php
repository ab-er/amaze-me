<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "contact"; // اسم قاعدة البيانات

// الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// جلب البيانات من النموذج باستخدام $_POST
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// التحقق من صحة البريد الإلكتروني
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // استخدام استعلام مُجهز لمنع هجمات SQL Injection
    $stmt = $conn->prepare("INSERT INTO feedback (fldName, fldEmail, fldMessage) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // تنفيذ الاستعلام والتحقق من النجاح
    if ($stmt->execute()) {
        echo "تم إرسال الرسالة بنجاح";
    } else {
        echo "Error: " . $stmt->error;
    }

    // إغلاق الاستعلام
    $stmt->close();
} else {
    echo "البريد الإلكتروني غير صحيح";
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();

?>
