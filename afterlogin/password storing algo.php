
<?php

$plaintext = 'My secret message 1234';
$password = '3sc3RLrpd17';
$method = 'aes-256-cbc';

$key = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
echo "Key:" . $key . "\n";
echo "</br>";

// IV must be exact 16 chars (128 bit)
$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
$encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));

// My secret message 1234
$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);

echo 'plaintext=' . $plaintext . "\n";
echo "</br>";
echo 'cipher=' . $method . "\n";
echo "</br>";
echo 'encrypted to: ' . $encrypted . "\n";echo "</br>";

echo 'decrypted to: ' . $decrypted . "\n\n";

?>