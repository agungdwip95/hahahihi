<?php
echo "=== Telegram Sender (Bot API) ===\n\n";

// Input BOT Token
echo "Masukkan BOT TOKEN:\nInput : ";
$botToken = trim(fgets(STDIN));
if (empty($botToken)) {
    exit("BOT Token tidak boleh kosong!\n");
}

// Input Chat ID
echo "Masukkan CHAT ID:\nInput : ";
$chatId = trim(fgets(STDIN));
if (empty($chatId) || !is_numeric($chatId)) {
    exit("Chat ID tidak valid!\n");
}

// Input Pesan
echo "Pesan yang mau dikirim:\nInput : ";
$pesan = trim(fgets(STDIN));
if (empty($pesan)) {
    exit("Pesan tidak boleh kosong!\n");
}

// Input jumlah
echo "Jumlah pengiriman?\nInput : ";
$jumlah = trim(fgets(STDIN));
if (!is_numeric($jumlah) || $jumlah <= 0) {
    exit("Jumlah tidak valid!\n");
}

for ($i = 0; $i < $jumlah; $i++) {
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $postData = [
        'chat_id' => $chatId,
        'text' => $pesan
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "[" . ($i + 1) . "] Pesan terkirim ke Chat ID: $chatId\n";
}
