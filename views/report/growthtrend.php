<?php
$this->title = 'Growth trend';
$this->params['breadcrumbs'][] = $this->title;
$pointspermonth = json_encode([1,2,3,4,5,6,7,8,9,10,11,12]);
?>
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_days_weeks_months.php', [
                                'data' => [],
                                'url'  => '/report/growthtrend',
                                'from' => date( 'Y-m-d' )
                        ])?>
                </div>
            </div>
            <div class="row">
                <?= $this->render('//_notification'); ?>  
            </div>
        </div>
    </div>
<div class=row>
    <div class="col-md-12">
        <input type="hidden" name="pointspermonth" id="pointspermonth" value="<?= $pointspermonth ?>"/>
        
        <div id="growthtrendchartcontainer" style="min-width: 310px; height: 500px; margin: 0 auto">chart</div>

    </div>
</div>