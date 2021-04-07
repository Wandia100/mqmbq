<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
use luc\tourist\Tourist;

?>
<div class="app-sidebar sidebar-shadow bg-heavy-rain sidebar-text-dark side-bar-toggle">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
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
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-home"></i> Home', Url::home(), ['class' => ''])?>
                </li>
                <li class="app-sidebar__heading tour-step" title="User Administration"
                    data-content="User Management Module. Menu options to manage, edit, view, create users.">
                    USER MANAGEMENT
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-users"></i> List All Users', Url::to(['/users/index']), ['class' => '', 'id' => 'users'])?>
                </li>
                <li class="app-sidebar__heading tour-step" title="User Administration"
                    data-content="User Management Module. Menu options to manage, edit, view, create users.">
                    STATION MANAGEMENT
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-signal"></i> Stations', Url::to(['/stations/index']), ['class' => '', 'id'=>'manage_categories'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-microphone"></i> Station Shows', Url::to(['/stationshows/index']), ['class' => '', 'id'=>'manage_categories'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-gift"></i> Prizes', Url::to(['/prizes/index']), ['class' => '', 'id' => 'newapp'])?>
                </li>
                <li class="app-sidebar__heading tour-step" data-content="Application Management Options. Add/Edit/View Application(s) options"
                    title="Application Management">
                    REPORTS
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-chart-bar"></i> Mpesa Report', Url::to(['/mpesapayments/index']), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-chart-bar"></i> Transactions Report', Url::to(['/transactionhistories/index']), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-chart-bar"></i> Winners Report',  Url::to(['/winninghistories/index']), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-chart-bar"></i> Financial Summary', Url::to(['/financialsummaries/index']), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-chart-bar"></i> Presenter Commission', Url::to(['/commissions/index','t'=>'p']), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-chart-bar"></i> Management Commission', Url::to(['/commissions/index','t'=>'m']), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-chart-bar"></i> Disbursement Report', Url::to(['/disbursements/index','t'=>'m']), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                
                <li class="app-sidebar__heading tour-step" data-content="Application Management Options. Add/Edit/View Application(s) options"
                    title="Application Management">
                    FINANCE
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-paper-plane
                    "></i> Disbursement', Url::home(), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-user"></i> Presenter Disbursement', Url::home(), ['class' => '', 'id' => 'appmenu'])?>
                </li>
                
                <li class="app-sidebar__heading tour-step" title=" Module"
                    data-content="Role Based Access Control Management for the applications. Set up Roles and Rules for the different managed Applications"
                >
                    RBAC
                </li>
                <li>                    
                        <?= Html::a('<i class="metismenu-icon fa fa-chalkboard-teacher"></i> Permission Group', Url::to(['/permissiongroup/index', 'type' => \yii\rbac\Item::TYPE_ROLE]), ['class' => ''])?>
                    
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-clipboard-list"></i> Permissions', Url::to(['/permission/index', 'type' => yii\rbac\Item::TYPE_PERMISSION]))?>
                    
                </li>
                
                <li class="app-sidebar__heading tour-step" title="API Menu" data-content="API Documentation for the system. List and usage of different endpoints.">
                    API
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fas fa-print"></i> API Documentation', Url::to(['/api-docs']), ['target' => '_blank'])?>
                </li>
                <li>
                    <?= Html::a('<i class="metismenu-icon fa fa-user-secret"></i> API Users/Applications', Url::to(['/user/api-users']))?>
                </li>
                <li class="app-sidebar__heading tour-step" title="User Guides/Documentation and FAQs"
                    data-content="This is a link to documents that are associated with this system and frequently asked questions(FAQs)."
                >
                    Help
                </li>
                <li>
                    <a target="_blank" >
                        <i class="metismenu-icon pe-7s-graph2">
                        </i>
                        User Guide
                    </a>
                    <a target="_blank">
                        <i class="metismenu-icon pe-7s-graph2">
                        </i>
                        FAQs
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
