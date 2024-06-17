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
            <?php $serverName = $_SERVER['SERVER_NAME']; ?>
    <input type="hidden" name="host" id="host" value="<?= $serverName ?>">
    <input type="hidden" name="port" id="port" value="<?= $_SERVER['SERVER_PORT'] ?>">
            <?php
                $superadminvisibility = '';
                $adminvisibility = '';
                $presentervisibility ='';
                $managementvisibility = '';
                $stationmanagementvisibility = '';
                $customercarevisibility = '';
                if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group == 1){
                    $superadminvisibility = 'hidden';
                }
                else if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group == 2){
                    $adminvisibility = 'hidden';
                }
                else if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group == 3){
                     $presentervisibility = 'hidden';
                }else if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group == 4){
                     $managementvisibility = 'hidden';
                }else if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group == 5){
                     $stationmanagementvisibility = 'hidden';
                }else if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group == 6){
                     $customercarevisibility = 'hidden';
                }

                if(!Yii::$app->user->isGuest)
                {
                    echo $this->render('partials/top-header', ['superadminvisibility'=>$superadminvisibility,'adminvisibility'=>$adminvisibility,'presentervisibility'=>$presentervisibility,'managementvisibility'=>$managementvisibility,'stationmanagementvisibility'=>$stationmanagementvisibility,'customercarevisibility'=>$customercarevisibility]);

                }
                 ?>
            <?php
            // echo $this->render('partials/theme-setting', []); 
            ?>
            <div class="app-main">
                <?php
                if(!Yii::$app->user->isGuest)
                {
                    echo $this->render('partials/sidebar', ['superadminvisibility'=>$superadminvisibility,'adminvisibility'=>$adminvisibility,'presentervisibility'=>$presentervisibility,'managementvisibility'=>$managementvisibility,'stationmanagementvisibility'=>$stationmanagementvisibility,'customercarevisibility'=>$customercarevisibility]);
                }
                  ?>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        
                        <?php
                            if(in_array(Yii::$app->controller->id, Yii::$app->params['reportscontrollers']) && Yii::$app->controller->action->id == 'index'){
                                //do nothing
                            }else{
                                if(!Yii::$app->user->isGuest)
                                {
                                    echo $this->render('partials/title-section', ['title' => $this->title]);
                                } 
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
