<?php
declare(strict_types=1);

function getPayFastConfig(): array {
    // Toggle sandbox for testing
    $isSandbox = true; 
    return [
        'merchant_id'  => $isSandbox ? '10000100' : getSetting('payfast_merchant_id', ''),
        'merchant_key' => $isSandbox ? '46f0cd694581a' : getSetting('payfast_merchant_key', ''),
        'passphrase'   => $isSandbox ? '' : getSetting('payfast_passphrase', ''),
        'url'          => $isSandbox ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process',
        'itn_url'      => $isSandbox ? 'https://sandbox.payfast.co.za/eng/query/validate' : 'https://www.payfast.co.za/eng/query/validate',
    ];
}

function generatePayFastSignature(array $data, string $passphrase = ''): string {
    $pfOutput = '';
    foreach ($data as $key => $val) {
        if ($val !== '' && $key !== 'signature') {
            $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
        }
    }
    $getString = substr($pfOutput, 0, -1);
    if (!empty($passphrase)) {
        $getString .= '&passphrase=' . urlencode(trim($passphrase));
    }
    return md5($getString);
}

function verifyPayFastITN(array $data, string $passphrase = ''): bool {
    $returnString = '';
    foreach ($data as $key => $val) {
        if ($key !== 'signature') {
            $returnString .= $key . '=' . urlencode(trim($val)) . '&';
        }
    }
    $returnString = substr($returnString, 0, -1);
    if (!empty($passphrase)) {
        $returnString .= '&passphrase=' . urlencode(trim($passphrase));
    }
    return md5($returnString) === ($data['signature'] ?? '');
}

function pfValidIP(): bool {
    $validHosts = ['www.payfast.co.za', 'sandbox.payfast.co.za', 'w1w.payfast.co.za', 'w2w.payfast.co.za'];
    $validIps = [];
    foreach ($validHosts as $host) {
        $ips = gethostbynamel($host);
        if ($ips !== false) $validIps = array_merge($validIps, $ips);
    }
    return in_array($_SERVER['REMOTE_ADDR'] ?? '', $validIps, true);
}

function pfValidData(array $data, string $itnUrl): bool {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $itnUrl);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ['pf_param_string' => http_build_query($data)]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response === 'VALID';
}