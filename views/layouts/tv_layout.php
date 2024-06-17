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
        <div class="app-container bg-dark text-white">
            <?php $serverName = $_SERVER['SERVER_NAME']; ?>
    <input type="hidden" name="host" id="host" value="<?= $serverName ?>">
    <input type="hidden" name="port" id="port" value="<?= $_SERVER['SERVER_PORT'] ?>">

            <div class="app-main">

                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <?=$content; ?>
                    </div>
                    <div class="app-wrapper-footer">
                        <?=$this->render('partials/footer', []); ?>
                    </div>    
                </div>
            </div>
        </div>
<div id="cover"></div>
<div id="progressModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12" style="text-align: center">
                                <img src="<?php
                                echo \yii\helpers\Url::base(); ?>/images/ajax-loader.gif">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
