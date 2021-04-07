<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\AdminAsset;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (Yii::$app->session->hasFlash('success')):?>
               
            <?php elseif (Yii::$app->session->hasFlash('error')):?>
                
            <?php endif; ?>


        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header closed-sidebar">
            <?= $this->render('partials/top-header', []); ?>
            <?php
            // echo $this->render('partials/theme-setting', []); 
            ?>
            <div class="app-main">
                <?= $this->render('partials/sidebar', []); ?>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        
                        <?php
                            if(!in_array(Yii::$app->controller->id, ['mpesapayments'])){
                               echo $this->render('partials/title-section', ['title' => $this->title]); 
                            }
                        ?>
                        <?=$content; ?>
                    </div>
                    <div class="app-wrapper-footer">
                        <?=$this->render('partials/footer', []); ?>
                    </div>    
                </div>
            </div>
        </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
