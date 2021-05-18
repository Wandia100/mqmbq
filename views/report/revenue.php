<?php
$this->title = 'Revenue';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => [],
                                'url'  => '/report/revenue',
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

<table class="table table-striped table-hover">
    <thead>
        <tr>
        <th>Day</th>
        <th>Total Revenue</th>
        <th>Total Awarded</th>
        <th>Net Revenue</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $total_revenue=0;
    $total_awarded=0;
    $total_net_revenue=0;
    $count=count($data);
    for($i=0;$i<$count; $i++)
    {
        $row=$data[$i];
        $net_revenue=round(($row['total_revenue']-$row['payout']));
        $total_revenue+=$row['total_revenue'];
        $total_awarded+=$row['payout'];
        $total_net_revenue+=$net_revenue;
        ?>
            <tr>
            <td><?=$row['the_day'];?></td>
            <td><?=number_format($row['total_revenue']);?></td>
            <td><?=number_format($row['payout']);?></td>
            <td><?=number_format($net_revenue);?></td>
            </tr>
            <?php
        
    }
    if($count > 0)
    {
        ?>
        <tr>
        <td class="font-weight-bold" >TOTAL</td>
        <td class="font-weight-bold" ><?=number_format($total_revenue);?></td>
        <td class="font-weight-bold" ><?=number_format($total_awarded);?></td>
        <td class="font-weight-bold" ><?=number_format($total_net_revenue);?></td>
        </tr>
        <?php
    }
        ?>
    </tbody>
</table>
</div>
</div>