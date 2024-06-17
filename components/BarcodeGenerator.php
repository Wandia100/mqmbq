<!-- <?php

namespace app\components;

use yii\base\Widget;
use Zend\Barcode\Barcode;
use Yii;

class BarcodeGenerator extends Widget
{
    public $item;
    public $config;

    public function run()
    {
        // Define the path and URL for the barcode image
        $barcodeDir = Yii::getAlias('@webroot') . '/barcodes';
        $barcodePath = $barcodeDir . '/' . $this->item->generate_barcode . '.png';
        $barcodeUrl = Yii::getAlias('@web') . '/barcodes/' . $this->item->generate_barcode . '.png';

        // Ensure the barcode directory exists
        if (!is_dir($barcodeDir)) {
            if (!mkdir($barcodeDir, 0777, true) && !is_dir($barcodeDir)) {
                Yii::error('Failed to create directory: ' . $barcodeDir);
                return 'Error creating barcode directory';
            }
        }

        // Generate the barcode image and save it to the file if it doesn't already exist
        if (!file_exists($barcodePath)) {
            $barcodeOptions = [
                'text' => $this->item->generate_barcode,
                'drawText' => false,
            ];

            // Adjust the renderer options for better fit
            $rendererOptions = [
                'imageType' => 'png',
                'width' => isset($this->config['width']) ? $this->config['width'] : 700, // Increased width
                'height' => isset($this->config['height']) ? $this->config['height'] : 400, // Increased height
                'fontSize' => 10, // Smaller font size if needed
                'factor' => 2, // Adjust scale factor
            ];

            try {
                $imageResource = Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions)->draw();
                imagepng($imageResource, $barcodePath);
                imagedestroy($imageResource);
            } catch (\Exception $e) {
                Yii::error('Failed to generate barcode: ' . $e->getMessage());
                return 'Error generating barcode image';
            }
        }

        // Check if the file exists and is readable
        if (!file_exists($barcodePath) || !is_readable($barcodePath)) {
            Yii::error('Barcode image file does not exist or is not readable: ' . $barcodePath);
            return 'Error accessing barcode image';
        }

        // Return the HTML image tag
        return '<img src="' . $barcodeUrl . '" alt="Barcode Image">';
    }
} -->
