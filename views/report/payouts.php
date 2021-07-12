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
    
<b>Disbursements</b>
<table class="table table-striped table-hover">
    <thead>
        <tr>
        <th>STATION</th>
        <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php
    for($i=0;$i< count($response1); $i++)
    {
        ?>
        <tr>
        <td><?=$response1[$i]['name'];?></td>
        <td><?=$response1[$i]['totalamount'];?></td>
        </tr>
        <?php
    }
        ?>
    </tbody>
</table>

<br/><br/>
<b>Commissions</b>
<table class="table table-striped table-hover">
    <thead>
        <tr>
        <th>Station</th>
        <th>Presenter</th>
        <th>Phone</th>
        <th>Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php
    for($i=0;$i< count($response2); $i++)
    {
        ?>
        <tr>
        <td><?=$response2[$i]['name'];?></td>
        <td><?=$response2[$i]['presentername'];?></td>
        <td><?=$response2[$i]['phone_number'];?></td>
        <td><?=$response2[$i]['totalamount'];?></td>
        </tr>
        <?php
    }
        ?>
    </tbody>
</table>
</div>
</div>