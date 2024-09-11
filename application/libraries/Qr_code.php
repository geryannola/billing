<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');

class Qr_code {

    public function __construct() {
        // Optional: You can load configurations or helpers here if needed
    }

    /**
     * Generate QR code and save it to the given path
     *
     * @param string $text Text to encode in the QR code
     * @param string $filePath Path where the QR code image will be saved
     * @param int $size Size of the QR code
     * @param int $margin Margin around the QR code
     * @return bool Returns true on success, false on failure
     */
    public function generate($text, $filePath, $size = 3, $margin = 4) {
        try {
            QRcode::png($text, $filePath, QR_ECLEVEL_L, $size, $margin);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
