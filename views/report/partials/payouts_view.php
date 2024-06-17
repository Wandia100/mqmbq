<b>Disbursements (<?=$start_date?> to <?=$end_date?>)</b>
<table class="table table-striped table-hover">
    <thead>
        <tr>
        <th>STATION</th>
        <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $total = 0;
    for($i=0;$i< count($response1); $i++)
    {
        ?>
        <tr>
        <td><?=$response1[$i]['name'];?></td>
        <td><?=number_format($response1[$i]['totalamount'],2);?></td>
        </tr>
        <?php
        $total = $total + $response1[$i]['totalamount'];
    }
        ?>
        <tr>
            <td><b>Total</b></td>
            <td><b><?=number_format($total,2)?></b></td>
        </tr>
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
    $totalcom = 0;
    for($i=0;$i< count($response2); $i++)
    {
        ?>
        <tr>
        <td><?=$response2[$i]['name'];?></td>
        <td><?= $response2[$i]['presentername'];?></td>
        <td><?= $response2[$i]['phone_number'];?></td>
        <td><?= number_format($response2[$i]['totalamount'],2);?></td>
        </tr>
        <?php
        $totalcom = $totalcom + $response2[$i]['totalamount'];
    }
        ?>
        <tr>
            <td><b>TOTAL</b></td>
            <td></td>
            <td></td>
            <td><b><?=number_format($totalcom,2)?></b></td> 
        </tr>
    </tbody>
</table>