<?php

function verifySmartCaptcha(string $token): bool
{
    if ($token === '') {
        return false;
    }

    $logDir  = dirname(__DIR__) . '/logs';
    $logFile = $logDir . '/captcha.log';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $secret = 'YOUR_SECRET_KEY';

    $payload = json_encode([
        'secret' => $secret,
        'token'  => $token,
        'ip'     => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    $ch = curl_init('https://smartcaptcha.yandexcloud.net/validate');

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_TIMEOUT        => 10,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    file_put_contents(
        $logFile,
        date('c') . " HTTP {$httpCode} RESPONSE: {$response}\n",
        FILE_APPEND
    );

    if ($httpCode !== 200) {
        return false;
    }

    $result = json_decode($response, true);

    return isset($result['status']) && $result['status'] === 'ok';
}
