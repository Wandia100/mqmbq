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
    for($i=0;$i< count($data); $i++)
    {
        $row=$data[$i];
        ?>
            <tr>
            <td><?=$row['the_day'];?></td>
            <td><?=$row['total_revenue'];?></td>
            <td><?=$row['payout'];?></td>
            <td><?=round(($row['total_revenue']-$row['payout']));?></td>
            </tr>
            <?php
        
    }

        ?>
    </tbody>
</table>
</div>
</div>