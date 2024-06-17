<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Complete Transaction';

?>

<?php if (!empty($basketItems)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Select</th>
                <th>Name</th>
                <th>Description</th>
                <th>Mode Payment</th>
                <th>Amount</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($basketItems as $item): ?>
                <tr>
                    <td><?= Html::checkbox('selection[]', false, ['value' => $item->id]) ?></td>
                    <td><?= Html::encode($item->name) ?></td>
                    <td><?= Html::encode($item->description) ?></td>
                    <td><?= Html::encode($item->mode_payment) ?></td>
                    <td class="amount"><?= Html::encode($item->amount) ?></td>
                    <td><?= Html::encode($item->quantity) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="users-update">
        <?php $form = ActiveForm::begin(['action' => ['basket/complete']]); ?>
        <!-- Hidden input to store selected IDs -->
        <?php foreach ($basketItems as $item): ?>
            <?= Html::hiddenInput('selectedIds[]', $item->id, ['class' => 'selected-ids']) ?>
        <?php endforeach; ?>
        <div class="form-group">
            <?= $form->field($model, 'money_given')->textInput(['maxlength' => true, 'id' => 'money_given']) ?>
            <?= $form->field($model, 'balance')->textInput(['maxlength' => true, 'id' => 'balance', 'readonly' => true]) ?>
            <?= $form->field($model, 'totalprice')->textInput(['maxlength' => true, 'id' => 'totalprice', 'readonly' => true]) ?>
        </div>
        <div class="form-group" style="display: flex; justify-content: center;">
            <?= Html::submitButton('Complete', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Decline', ['itemsale/index'], ['class' => 'btn btn-danger']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <?php
    // JavaScript section to calculate totalprice and update balance
    $js = <<<JS
        $(document).ready(function() {
            calculateTotal();
            $('#money_given').on('input', function() {
                calculateBalance();
            });
        });

        function calculateTotal() {
            var total = 0;
            $('.amount').each(function() {
                total += parseFloat($(this).text());
            });
            $('#totalprice').val(total.toFixed(2));
            calculateBalance(); // Calculate balance initially
        }

        function calculateBalance() {
            var moneyGiven = parseFloat($('#money_given').val());
            var total = parseFloat($('#totalprice').val());
            var balance = moneyGiven - total;
            $('#balance').val(balance.toFixed(2));
        }
    JS;

    $this->registerJs($js);
    ?>
<?php else: ?>
    <p>No items found in basket.</p>
<?php endif; ?>
