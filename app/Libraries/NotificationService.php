<?php

namespace App\Libraries;

class NotificationService
{
    private $apiUrl = 'http://localhost:3000/api/sendText'; // Default WAHA endpoint
    private $sessionName = 'default';

    public function __construct()
    {
        // Jika pakai .env, bisa diubah: $this->apiUrl = getenv('WAHA_API_URL') ?: $this->apiUrl;
    }

    public function sendWhatsAppMessage($to, $message)
    {
        if (empty($to)) return false;

        // WAHA expects phone number with country code, e.g. 628...
        // Membersihkan nomor telepon, misal dari 08... menjadi 628...
        $to = preg_replace('/[^0-9]/', '', $to);
        if (substr($to, 0, 1) === '0') {
            $to = '62' . substr($to, 1);
        }

        $payload = [
            'chatId' => $to . '@c.us',
            'text'   => $message,
            'session'=> $this->sessionName
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $success = $httpCode >= 200 && $httpCode < 300;

        // Jika WAHA tidak menyala (cURL gagal), kita simpan pesannya ke dalam file log.
        // Ini sangat berguna untuk presentasi dosen, agar kamu tetap bisa menunjukkan isi pesan yang "dikirim".
        if (!$success || $curlError) {
            $logPath = WRITEPATH . 'logs/whatsapp_mock.log';
            $logMessage = "========================================\n"
                        . "WAKTU : " . date('Y-m-d H:i:s') . "\n"
                        . "TUJUAN: +" . $to . "\n"
                        . "PESAN :\n" . $message . "\n"
                        . "========================================\n\n";
            file_put_contents($logPath, $logMessage, FILE_APPEND);
        }

        return $success;
    }
}
