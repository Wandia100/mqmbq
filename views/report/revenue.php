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
        <th>Category</th>
        <th>Day</th>
        <th>Total Revenue</th>
        <th>Total Profit</th>
        <th>Net Revenue</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $total_revenue=0;
    $total_profit=0;
    $total_net_revenue=0;
    $count=count($data);
    for($i=0;$i<$count; $i++)
    {
        $row=$data[$i];
        $total_revenue+=$row->total_revenue;
        $total_awarded+=$row->total_profit;
        $total_net_revenue+=$row->net_revenue;
        ?>
            <tr>
            <td><?=$row->station_name;?></td>
            <td><?=$row->revenue_date;?></td>
            <td><?=number_format($row->total_revenue);?></td>
            <td><?=number_format($row->total_profit);?></td>
            <td><?=number_format($row->net_revenue);?></td>
            </tr>
            <?php
        
    }
    if($count > 0)
    {
        ?>
        <tr>
        <td class="font-weight-bold" ></td>
        <td class="font-weight-bold" >TOTAL</td>
        <td class="font-weight-bold" ><?=number_format($total_revenue);?></td>
        <td class="font-weight-bold" ><?=number_format($total_profit);?></td>
        <td class="font-weight-bold" ><?=number_format($total_net_revenue);?></td>
        </tr>
        <?php
    }
        ?>
    </tbody>
</table>
</div>
</div>