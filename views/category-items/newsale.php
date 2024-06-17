<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoryItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsale-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <!-- Button to fetch data -->
    <button id="fetch-data-btn" class="btn btn-primary">Fetch Data</button>

    <!-- Container to display fetched data -->
    <div id="data-container"></div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item', // Adjust this if you have a specific item view file
    ]) ?>
</div>
<?php
$this->registerJs(<<<JS
    $('#fetch-data-btn').on('click', function() {
        $.ajax({
            url: 'index', // URL to the controller action
            type: 'GET',
            success: function(data) {
                // Display the fetched data in the data container
                $('#data-container').html(data);
            },
            error: function() {
                alert('Error fetching data.');
            }
        });
    });
JS
);

