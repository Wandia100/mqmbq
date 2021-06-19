<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

$icon = ArrayHelper::getValue($this->params, 'view-icon', 'pe-7s-folder');
?>

<div class="app-page-title">
        <div class="row"> 
                            <div class="col-12" style="text-align: center;font-weight: bold">
                                <?= $this->render('//_notification'); ?>  
                            </div>
                                    
                        </div>
   
    <div class="page-title-wrapper">
              
        <div class="page-title-heading">
            <div class="page-title-icon tour-step" title="<?= $this->title ?>"
                 data-content="<?= ArrayHelper::getValue($this->params, 'view-description', '') ?>" >
                <i class="<?= $icon ?> icon-gradient bg-asteroid">
                </i>
            </div>
            <div>
                <?= $title ?>
                <div class="page-title-subheading">
                    <?= ArrayHelper::getValue($this->params, 'view-description', '') ?>
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <button type="button" class="btn-shadow mr-3 btn btn-dark" id="tour-step-initiate">
                <i class="fa fa-star"></i>
            </button>

            <div class="d-inline-block dropdown">
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow text-light dropdown-toggle btn bg-asteroid tour-step"
                        data-content="Click here to get a list dropdown of the different actions you can perform on this page e.g. create/delete" title="Page Actions Listed Here">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="fa fa-business-time fa-w-20"></i>
                    </span>
                    <strong>Page Actions</strong>
                </button>
                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                    <ul class="nav flex-column">
                        <?php foreach (ArrayHelper::getValue($this->params, 'view-actions', []) as $item): ?>
                            <li class="nav-item">
                            <?= ArrayHelper::getValue($item, 'content', '') ?>
                            </li>
                        <?php endforeach; ?>
                        <?php  if(Yii::$app->controller->id == 'stationshows' && Yii::$app->controller->action->id == 'view'){ ?> 
                            <li class="nav-item"> 
                                <a href="<?= Url::to(['/stationshows/view','id'=>$_GET['id'],'rs'=>'1'])?>"> Show Presenters</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= Url::to(['/stationshows/view','id'=>$_GET['id'],'rs'=>'2'])?>">Show Prizes</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= Url::to(['/stationshows/view','id'=>$_GET['id'],'rs'=>'3'])?>">Show Commissions</a>
                            </li>
                        <?php } ?>  
                        <?php  if(Yii::$app->controller->id == 'report' && Yii::$app->controller->action->id == 'hourlyperformance'){ ?>
                            <li class="nav-item"> 
                                <a href="<?= Url::to(['/report/exporthourlyperformance','from'=> isset($_GET['from'])?$_GET['from']:date("Y-m-d")])?>"> Export</a>
                            </li>
                        <?php } ?>  
                    </ul>
                </div>
            </div>
        </div>    
    </div>
</div>