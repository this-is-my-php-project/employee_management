<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('getAESKey')) {
    /**
     * @return string
     */
    function getAESKey(): array
    {
        return [
            'key' => Config::get('app.aes.key'),
            'iv' => Config::get('app.aes.iv'),
            'cipher' => Config::get('app.cipher'),
            'options' => 0,
        ];
    }
}

if (!function_exists('decryptData')) {
    /**
     * @param $encryptedData
     * @return string|int
     */
    function decryptData(string $encryptedData): string
    {
        return openssl_decrypt(
            $encryptedData,
            getAESKey()['cipher'],
            getAESKey()['key'],
            getAESKey()['options'],
            getAESKey()['iv']
        );
    }
}

if (!function_exists('encryptData')) {
    /**
     * @param $data
     * @return string
     */
    function encryptData(string $data): string
    {
        return openssl_encrypt(
            $data,
            getAESKey()['cipher'],
            getAESKey()['key'],
            getAESKey()['options'],
            getAESKey()['iv']
        );
    }
}
