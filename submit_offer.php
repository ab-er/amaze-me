<?php
header("Content-Type: text/html; charset=UTF-8");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// إعدادات قاعدة البيانات
$host = 'localhost'; 
$dbname = 'car_rental';
$username = 'root'; // استبدل بـ اسم المستخدم الخاص بك
$password = ''; // استبدل بـ كلمة المرور الخاصة بك

try {
    // إنشاء اتصال بقاعدة البيانات
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // التحقق مما إذا تم إرسال النموذج
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // استلام البيانات
        $name = htmlspecialchars($_POST['name']);
        $country_code = htmlspecialchars($_POST['country_code']);
        $mobile = htmlspecialchars($_POST['mobile']);
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

        // إعداد جملة SQL لإدخال البيانات
        $stmt = $pdo->prepare("INSERT INTO offers (name, country_code, mobile, email) VALUES (:name, :country_code, :mobile, :email)");

        // ربط القيم
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country_code', $country_code);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);

        // تنفيذ الإجراء وعرض رسالة النجاح
        if ($stmt->execute()) {
            echo "<h2 style='text-align: center; color: green; font-family: Arial;'>تم الاستئجار بنجاح!</h2>";
            echo "<p style='text-align: center; font-family: Arial;'>شكرًا يا ، سنقوم بالتواصل معك قريبًا.</p>";
        } else {
            echo "<h2 style='text-align: center; color: red; font-family: Arial;'>حدث خطأ أثناء معالجة الطلب.</h2>";
        }
    }
} catch (PDOException $e) {
    // عرض رسالة الخطأ إذا فشل الاتصال
    echo "<h2 style='text-align: center; color: red; font-family: Arial;'>خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage() . "</h2>";
}
?>
