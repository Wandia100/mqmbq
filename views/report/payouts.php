<?php
    $d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
    $this->title = 'Payouts FROM '.$start_date.' TO '.$end_date;
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
            'data' => [],
            'url'  => '/report/payouts',
            'from' => date( 'Y-m-01'),
            'to' => date("Y-m-$d")
        ])?>
    </div>
</div>
<div class=row>
    <div class="col-md-12">
        <?=$this->renderFile('@app/views/report/partials/payouts_view.php', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'response1' => $response1,
            'response2' => $response2
        ])?>

    </div>
</div>