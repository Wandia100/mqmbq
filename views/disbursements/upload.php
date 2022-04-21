<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title= 'Upload | Disbursements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title text-uppercase"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="panel-body">
        <div class="container-fluid">
            <div class="row">
                <?php if (count($success) > 0) { ?>
                    <div class="alert alert-success fade show">
                        <p> Data uploaded successfully</p>
                        Saved Lines: <?= " (" . count($success) . ") records in total." ?>
                        <?php //echo implode(",", $success);
                        echo " (" . count($success) . ") records in total." ?> 
                    </div>
                <?php } ?>
                <?php if (count($error) > 0) { ?>
                    <div class="alert alert-danger fade show">
                        Ignored Lines: <?= " (" . count($error) . ") records in total."?>
                        <?php //echo implode(",", $error); ?> 
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="note note-yellow text-black m-b-15">
                    <div class="note-icon f-s-20">
                        <i class="fa fa-lightbulb fa-2x"></i>
                    </div>
                    <div class="note-content">
                        <h4 class="m-t-5 m-b-5 p-b-2">Hints:</h4>
                        <ul class="m-b-5 p-l-25">
                            <li>The format should be as follows:
                                <ul>
                                    <li>Column[1]-name</li>
                                    <li>Column[2]-phone number</li>
                                    <li>Column[3]-amount</li>
                                </ul>
                            </li>
                            <li>Then ensure file is in csv format.</li>
                            <li>Only documents (<strong>CSV</strong>) are allowed.</li>

                        </ul>
                    </div>
                </div>
            </div>

            <?php
            echo Html::beginForm(
                $action = yii\helpers\Url::base() . "/disbursements/upload",
                $method = 'post',
                $hmtmlOptions = array(
                    'id'      => 'airtel',
                    'class'   => 'form form-horizontal',
                    'enctype' => 'multipart/form-data'
                )
            );
            ?>
            <div class="form-group field-file ">
                <label class="control-label" for="file">Choose File</label>
                <input type="file" name="file" class="form-control-file" required="required">
                <div class="help-block p-t-10">Example: airtel.csv</div>
            </div>
            <div class="form-group ">
                <div class="col-sm-4">
                    <button type="submit" name="submit" class="form-control btn btn-primary"><i class="fa fa-file-upload"></i> Upload </button>
                </div>
            </div>
            <?php echo Html::endform(); ?>
        </div>
    </div>
</div>