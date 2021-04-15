<?php
$this->title = 'Hourly Performance';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=row>
<div class="col-md-12">

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <?php
            $stations=$response[0];
            for($i=0;$i<count($stations); $i++)
            {
                ?><th><?=strtoupper($stations[$i]); ?></th><?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
    <?php
    $k=0;
    for($i=1;$i< count($response); $i++)
    {
        ?><tr><?php
        for($j=0;$j<count($response[$i]); $j++)
        {
            ?>
            
            <td><?=$response[$i][$j];?></td>
            <?php
        }
        ?></tr><?php
    }

        ?>
    </tbody>
</table>
</div>
</div>