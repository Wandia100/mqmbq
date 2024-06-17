<?php

namespace app\components\libraries;

use Zend\Validator\Barcode;

class Zend
{
    public function __construct($class = null)
    {
        // Assuming your Yii2 application is located in the root directory of your server
        $yiiAppPath = dirname(__DIR__) . '/'; // Assuming your Yii2 app is in the root directory

        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $yiiAppPath . 'components/libraries');

        if ($class) {
            require_once $class . '.php';
            \Yii::info("Zend Class $class Loaded", 'zend');
        } else {
            \Yii::info("Zend Class Initialized", 'zend');
        }
    }

    public function load($class)
    {
        require_once $class . '.php';
        \Yii::info("Zend Class $class Loaded", 'zend');
    }
    
    public function setBarcode($code)
    {
        // Initialize Zend Barcode with CODE_128 type and default options
        $barcodeOptions = [
            'text' => $code, // Set the barcode text to the provided code
            // You can add more options here if needed
        ];
    
        try {
            // Create a barcode object
            $barcodeObject = new \Zend\Barcode\Object\Code128($barcodeOptions);
            //var_dump($barcodeObject);exit;
    
            // Create a renderer for the barcode object
            $renderer = new \Zend\Barcode\Renderer\Image($barcodeObject);
    
            // Render the barcode as a PNG image
            $barcodeImage = $renderer->draw();
            
            return $barcodeImage;
        } catch (\Exception $e) {
            // Handle any exceptions here
            return 'Error generating barcode: ' . $e->getMessage();
        }
    }
    
}
    

