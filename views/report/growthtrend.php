<?php
$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
$this->title = 'Growth trend';
$this->params['breadcrumbs'][] = $this->title;
$pointspermonth = json_encode([1,2,3,4,5,6,7,8,9]);
?>
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                        'data' => [],
                        'url'  => '/report/growthtrend',
                        'from' => date( 'Y-m-01'),
                        'to' => date("Y-m-$d")
                    ])?>
                </div>
                </div>
            </div>
            <div class="row">
                <?= $this->render('//_notification'); ?>  
            </div>
        </div>
<div class=row>
    <div class="col-md-12">
        <?php if ( (isset( $_GET['criterion'] ) && $_GET['criterion'] == 'daily')  || !isset( $_GET['criterion']) ) { ?>
            <textarea id="pointspermonth" class="hide"><?=$response?></textarea>
            <input type="hidden" name="titleholder" id="titleholder" value="HOURS"/>
            <textarea id="categoryid" class="hide"><?=$range?></textarea>
            <div id="growthtrendchartcontainer" style="min-width: 310px; height: 500px; margin: 0 auto">chart</div>
        <?php }elseif ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'monthly' ) { ?>
            <input type="hidden" name="pointspermonth" id="pointspermonth" value="<?=$response ?>"/>
            <input type="hidden" name="titleholder" id="titleholder" value="MONTHS"/>
            <textarea id="categoryid" class="hide">
                <?=json_encode(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])?>
            </textarea>
            <div id="growthtrendchartcontainer" style="min-width: 310px; height: 500px; margin: 0 auto">chart</div>
        <?php }elseif ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'range' ) { ?>
            <textarea id="pointspermonth" class="hide"><?=$response?></textarea>
            <input type="hidden" name="titleholder" id="titleholder" value="RANGE"/>
            <textarea id="categoryid" class="hide"><?=$range?></textarea>
            <div id="growthtrendchartcontainer" style="min-width: 310px; height: 500px; margin: 0 auto">chart</div>
        <?php } ?>    
    </div>
</div>