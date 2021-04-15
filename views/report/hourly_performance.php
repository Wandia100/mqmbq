<?php
$this->title = 'Hourly Performance';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=row>
<div class="col-md-12">

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>HOUR</th>
            <?php
            $station_count=count($stations);
            for($i=0;$i<$station_count; $i++)
            {
                ?><th><?=strtoupper($stations[$i]->name); ?></th><?php
            }
            ?>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $k=0;
    for($i=0;$i< count($hourly['transaction_histories']); $i++)
    {
        $row=$hourly['transaction_histories'][$i];
        ?>
        <tr>
        <td><?=$row['hour'];?></td>
        <?php
        $hr_res=$row['hour_results'];
        $hour_total=0;
        for($j=0;$j<count($hr_res); $j++)
        {
            ?>
            <td><?=$hr_res[$j]['amount'];?></td>
            
            <?php
            $total_amount+=$hr_res[$j]['amount'];    
        }
        ?>
        <td><?=$hour_total; ?></td>
        </tr>
        <?php
    }

        ?>
    </tbody>
</table>
</div>
</div>