<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Sale';
?>
<style>
    .form-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .form-group > div {
        flex: 1 1 calc(20% - 20px);
    }
    .inline-block {
        display: inline-block;
        vertical-align: top;
        margin-right: 20px;
    }
    .field-container {
        display: flex;
        gap: 20px;
    }
    .button-group {
        padding: 5px 20px;
        display: flex;
        gap: 20px;
        font-size: 16px;
        border-radius: 5px;
    }
    input[type="text"] {
        background-color: yellow;
        color: black;
    }
</style>

<div class="users-update">
    <?php $form = ActiveForm::begin(['id' => 'sale-form']); ?>
    <div class="form-group">
        <div>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
        <div>
            <?= $form->field($model, 'generate_barcode')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
        <div>
            <?= $form->field($model, 'outprice')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'outprice']) ?>
        </div>
        <div>
            <?= $form->field($model, 'quantity')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
        <div>
            <?= $form->field($model, 'howmany')->textInput(['maxlength' => true, 'id' => 'howmany']) ?>
        </div>
        <div>
            <?= $form->field($model, 'totalprice')->textInput(['maxlength' => true, 'id' => 'totalprice', 'readonly' => true]) ?>
        </div>
    </div>
    <div class="field-container">
        <div class="inline-block">
            <?= $form->field($model, 'modeofpayment')->dropDownList(['cash' => 'Cash', 'mpesa' => 'Mpesa'], ['prompt' => 'Select Payment Mode']) ?>
        </div>
    </div>
    <div class="form-group" style="display: flex; justify-content: center;">
        <?= Html::button('Save', ['class' => 'btn btn-success', 'onclick' => 'savePartial()']) ?>
        <?= Html::button('IntoBasket', ['class' => 'btn btn-primary', 'onclick' => 'intobasket()']) ?>
        <?= Html::a('Decline', ['itemsale/index'], ['class' => 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    document.getElementById('howmany').addEventListener('input', calculateTotalPrice);
    document.getElementById('moneyreceived').addEventListener('input', calculateBalance);

    function calculateTotalPrice() {
        var howmany = parseFloat(document.getElementById('howmany').value) || 0;
        var outprice = parseFloat(document.getElementById('outprice').value) || 0;
        var totalPrice = howmany * outprice;
        document.getElementById('totalprice').value = totalPrice.toFixed(2);
        calculateBalance();
    }function intobasket() {
        var form = document.getElementById('sale-form');
        form.action = '<?= \yii\helpers\Url::to(['basket/intobasket', 'id' => $model->id]) ?>';
        form.submit();
}



    // function savePartial() {
    //     var form = document.getElementById('sale-form');
    //     form.action = '<?= \yii\helpers\Url::to(['itemsale/save-partial', 'id' => $model->id]) ?>';
    //     form.submit();
    // }

    function completeSale() {
        var form = document.getElementById('sale-form');
        form.action = '<?= \yii\helpers\Url::to(['itemsale/complete-sale', 'id' => $model->id]) ?>';
        form.submit();
    }
</script>
