<!--+----------------------------------------------------------------------
|| author: Mkinuthia
||  Required Parameters
||
|+-----------------------------------------------------------------------
||         url:  @param string - path to the filter url e.g /mpesapayment/index
||
||        data:  @param array - Parameter passed to the url. Should be passed as key=>value.
||                   e.g ['id'=>$id]
||
|+-----------------------------------------------------------------------
||
||
++------------------------------------------------------------------------->

<?php

use yii\helpers\Html;
use kartik\datetime\DateTimePicker;
$action              = isset( $action ) && $action != "" ? $action : $url;
$start               = isset( $from ) && $from != "" ? $from : date('Y-m-d');
$end                 = isset( $to ) && $to != "" ? $to : date( 'Y-m-d' );
$params              = $data;
$new_params          = '';
$count               = 0;
$vt                  = 0;
foreach ( $params as $key => $value ) {
	if ( $count == 0 ) {
		if ( ! is_array( $value ) ) {
			$new_params .= '?';
			$new_params .= $key . '=' . $value;
		} else {
			$vt = 1;
			unset( $params[ $key ] );
		}
	} else {
		if ( ! is_array( $value ) ) {
			if ( $vt == 1 ) {
				$new_params .= '?' . $key . '=' . $value;
			} else {
				$new_params .= '&' . $key . '=' . $value;
			}
		} else {
			unset( $params[ $key ] );
		}
	}
	$count ++;
}
?>
<div class="row">
    <br><br>
    <div class="col-sm-offset-1 col-sm-11">
		<?php
			$id = str_replace( "/", "", $action );
			echo Html::beginForm(
				$action = yii\helpers\Url::base() . $action,
				$method = 'get',
				$hmtmlOptions = array( 'id' => $id, 'class' => 'form form-inline' )
			);
			?>
			<?php
			if ( isset( $_GET['from'] ) ) {
				$from = $_GET['from'];
			} else {
				$from = $start;
			}
			
			?>

			<?php if ( Yii::$app->session->hasFlash( 'error_to_from' ) ) { ?>
                <div class="alert alert-danger">
                    Error: Ensure you select  the start date 
                </div>
			<?php } ?>
					<div class="row">
					<div class="col-md-2">From:</div>
					<div class="col-md-4">
					<?= yii\jui\DatePicker::widget( [
                            'name'          => 'from',
                            'value'         => $from,
                            'dateFormat'    => 'yyyy-MM-dd',
                            'clientOptions' => [ 'defaultDate' => date('Y-m-d') ],
                            'options'       => [ 'class' => 'form-control inmfield required', ]
                    ] ) ?>
					&nbsp;&nbsp;
					</div>
					<div  class="col-md-2"></div>
					<div class="col-md-4">
					<button type="submit" class="form-control btn btn-primary"> 
                    <span class="glyphicon glyphicon-move"></span> Filter By day &nbsp;&nbsp;
                </button>
					</div>
					</div>

            <br>
			<?php echo Html::endform();
	
		?>
    </div>
</div>