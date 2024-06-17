<?php
use yii\widgets\ListView;

/* @var $dataProvider yii\data\ActiveDataProvider */

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item', // Adjust this if you have a specific item view file
]);
