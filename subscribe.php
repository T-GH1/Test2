<?php
// استقبل التوكن من التطبيق
$token = $_POST['token'] ?? '';

// عرض التوكن المستلم (للتجربة)
file_put_contents("log.txt", "Received token: " . $token . "\n", FILE_APPEND);

// إذا ما فيه توكن
if (!$token) {
    echo "No token received";
    exit;
}

// Server Key من Firebase
$serverKey = "AIzaSyCG0C_uLAIVHXHzvvBTuBT4at6W4GJ2iW0";

// رابط الاشتراك
$url = "https://iid.googleapis.com/iid/v1/$token/rel/topics/all";

$headers = [
    "Authorization: key=$serverKey",
    "Content-Type: application/json"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// سجل الرد برضه
file_put_contents("log.txt", "FCM response: $response\n", FILE_APPEND);

// الرد النهائي
if ($http_code == 200) {
    echo "تم الاشتراك بنجاح في topic all";
} else {
    echo "فشل الاشتراك. الرد من FCM: $response";
}
?>