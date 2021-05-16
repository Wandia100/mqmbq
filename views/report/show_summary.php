<?php
$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
$this->title = 'SHOW SUMMARY FROM '.$start_date.' TO '.$end_date;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-12">
<?=$this->renderFile('@app/views/layouts/partials/_datetime_filter_.php', [
                        'data' => [],
                        'url'  => '/report/showsummary',
                        'from' => date( 'Y-m-01'),
                        'to' => date("Y-m-$d 23:59:59")
                    ])?>
                </div>
</div>
<div class=row>
<div class="col-md-12">

<table class="table table-striped table-hover">
    <thead>
        <tr>
        <th>STATION NAME</th>
        <th>STATION SHOW NAME</th>
        <th>TOTAL REVENUE</th>
        <th>TOTAL COMMISSION</th>
        <th>TOTAL PAYOUTS</th>
        </tr>
    </thead>
    <tbody>
    <?php
    for($i=0;$i< count($response); $i++)
    {
        ?>
        <tr>
        <td><?=$response[$i]['station_name'];?></td>
        <td><?=$response[$i]['station_show_name'];?></td>
        <td><?=$response[$i]['total_revenue'];?></td>
        <td><?=$response[$i]['total_commission'];?></td>
        <td><?=$response[$i]['total_payout'];?></td>
        </tr>
        <?php
    }
        ?>
    </tbody>
</table>
</div>
</div>