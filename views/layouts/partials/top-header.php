<?php

use kartik\ipinfo\IpInfo;
use kartik\popover\PopoverX;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\user\models\User;

?>
<div class="app-header header-shadow bg-asteroid header-text-light">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div class="tour-step" data-content="Click here to collapse the sidebar menu" title="Sidebar">
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="open-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div class="tour-step" data-content="Click here to collapse the sidebar menu" title="Sidebar">
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper tour-step" title="Search" data-content="Type here to do global system search in the application"">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon"><span></span></button>
                </div>
                <button class="close"></button>
            </div>
            <ul class="header-menu nav">
                <li class="nav-item tour-step <?= $presentervisibility?> " data-content="Hourly Performance" title="Hourly Performance">
                    <?= Html::a('<i class="nav-link-icon fa fa-chart-bar"></i> Hourly Performance', ['/report/hourlyperformance'], ['class' => 'text-light'])?>
                </li>
                <li class="btn-group nav-item tour-step <?=$managementvisibility?>" data-content="Commission Summary" title="Commission Summary">
                    <?= Html::a('<i class="nav-link-icon fa fa-chalkboard"></i> Commission Summary', ['/report/commissionsummary'], ['class' => 'text-light'])?>
                </li>
                <li class="dropdown nav-item tour-step <?= $presentervisibility?>" data-content="Daily Awarding Report" title="Daily Awarding Report">
                    <?= Html::a('<i class="nav-link-icon fa fa-address-book"></i> Daily Awarding Report', ['/report/dailyawarding'], ['class' => 'text-light'])?>
                </li>
                <li class="dropdown nav-item tour-step <?= $presentervisibility?>" data-content="Revenue Report" title="Revenue Report">
                    <?= Html::a('<i class="nav-link-icon fa fa-chart-bar"></i> Revenue Report', ['/report/revenue'], ['class' => 'text-light'])?>
                 </li>   
                
                <?php if(Yii::$app->request->userIP !== '127.0.0.1'): ?>
                <li class="dropdown nav-item tour-step" data-content="Click to go to the configuration for the applications module" title="Settings/Apps Setup">
                    <?= IpInfo::widget([
                        'ip' => Yii::$app->request->userIP,
                        'popoverOptions' => [
                            'toggleButton' => ['class' => 'btn btn-secondary btn-lg'],
                            'placement' => PopoverX::ALIGN_BOTTOM_LEFT
                        ]
                    ]); ?>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left tour-step" data-content="Click here to access Account Settings, Logout etc. menu" title="Account Actions">
                            <div class="btn-group">
                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                <?= Yii::$app->user->identity->email?>
                                
                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-md-right bg-heavy-rain">
                                <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                
                                <button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                <div tabindex="-1" class="dropdown-divider"></div>
                                <?php if (Yii::$app->user->isGuest):?>
                                    <?php // Html::a('Login', Url::to('site/login'), ['class' => 'dropdown-item', 'tabindex' => '0'])?>
                                    <?=  Html::a('Login',['/site/login'], ['class' => 'dropdown-item', 'tabindex' => '0'])?>
                                <?php else:?>
                                    <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'dropdown-item', 'tabindex' => '0']
                                ) ?>
                                <?php endif;?>
                            </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                
                            </div>
                            <div class="widget-subheading">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>
