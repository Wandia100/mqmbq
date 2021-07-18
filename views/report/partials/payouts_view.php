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
    $total = 0;
    for($i=0;$i< count($response1); $i++)
    {
        ?>
        <tr>
        <td><?=$response1[$i]['name'];?></td>
        <td><?=$response1[$i]['totalamount'];?></td>
        </tr>
        <?php
        $total = $total + $response1[$i]['totalamount'];
    }
        ?>
        <tr>
            <td><b>Total</b></td>
            <td><b><?=$total?></b></td>
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
        <td><?= isset($response2[$i]['presentername'])?$response2[$i]['presentername']:'';?></td>
        <td><?= isset($response2[$i]['phone_number'])?$response2[$i]['phone_number']:'';?></td>
        <td><?= isset($response2[$i]['totalamount'])?$response2[$i]['totalamount']:'';?></td>
        </tr>
        <?php
        $totalcom = $totalcom + $response2[$i]['totalamount'];
    }
        ?>
        <tr>
            <td><b>TOTAL</b></td>
            <td></td>
            <td></td>
            <td><b><?=$totalcom?></b></td> 
        </tr>
    </tbody>
</table>