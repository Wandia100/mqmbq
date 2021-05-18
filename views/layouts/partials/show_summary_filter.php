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
||  Optional Parameters
||
|+-----------------------------------------------------------------------
||
||         action:  @param string - url of the form attribute.If not set, the url parameter
||                   will be used as the action.
||
||           from:  The start date of the filter. If not set then will be set to
||                   14 days ago.
||
||             to:  The end date of the filter. If not set then will be set to
||                   the current date.
||
++------------------------------------------------------------------------->

<?php

use yii\helpers\Html;
$action              = isset( $action ) && $action != "" ? $action : $url;
$start               = isset( $from ) && $from != "" ? $from : date( 'Y-m-d', strtotime( '-14 days' ) );
$end                 = isset( $to ) && $to != "" ? $to : date( 'Y-m-d' );
$params              = $data;
$new_params          = '';
$count               = 0;
$vt                  = 0;
$params['criterion'] = "";
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
<ul class="nav nav-pills">
    <li role="presentation"
		<?php
		if ( ! isset( $_GET['criterion'] ) || $_GET['criterion'] == 'daily' ) {
			echo "class='active'";
		}
		?>
    >
        <a href="<?= yii\helpers\Url::base() ?><?= $url ?><?= $new_params ?>daily"><i
                    class="fa fa-calendar-check-o"></i> Yesterday</a></li>
    <li role="presentation"
		<?php
		if ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'monthly' ) {
			echo "class='active'";
		}
		?>
    ><a marked="1"
        href="<?= yii\helpers\Url::base() ?><?= $url ?><?= $new_params ?>monthly"><i
                    class="fa fa-calendar"></i> Monthly</a></li>
    <li role="presentation"
		<?php
		if ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'range' ) {
			echo "class='active'";
		}
		?>
    ><a marked="1"
        href="<?= yii\helpers\Url::base() ?><?= $url ?><?= $new_params ?>range"><span
                    class="glyphicon glyphicon-calendar"></span> Range</a></li>
</ul>
<div class="row">
    <br><br>
    <div class="col-sm-offset-1 col-sm-11">
		<?php
		if ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'range' ) {
                    
		    $params['criterion']='range';
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
			if ( isset( $_GET['to'] ) ) {
				$to = $_GET['to'];
			} else {
				$to = $end;
			}
			?>

			<?php if ( Yii::$app->session->hasFlash( 'error_to_from' ) ) { ?>
                <div class="alert alert-danger">
                    Error: Ensure you select both the start date and the end date
                </div>
			<?php } ?>

            <div class="form-group">
                <label for="from">From:</label>
                    <?= yii\jui\DatePicker::widget( [
                            'name'          => 'from',
                            'value'         => $from,
                            'dateFormat'    => 'yyyy-MM-dd',
                            'clientOptions' => [ 'defaultDate' => '2015-01-01' ],
                            'options'       => [ 'class' => 'form-control inmfield required', ]
                    ] ) ?>
            </div>

            <div class="form-group">
                <label for="from">To:</label>
				<?= yii\jui\DatePicker::widget( [
					'name'          => 'to',
					'value'         => $to,
					'dateFormat'    => 'yyyy-MM-dd',
					'clientOptions' => [ 'defaultDate' => '2016-04-01' ],
					'options'       => [ 'class' => 'form-control inmfield required', ]
				] ) ?>
				<?php
				foreach ( $params as $key => $value ) {
					?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"></input>
					<?php
				}
				?>
            </div>
                
            <div class="form-group">
                <label</label>
                <br>
                <button type="submit" class="form-control btn btn-primary">
                    <span class="glyphicon glyphicon-move"></span> Filter By Range&nbsp;&nbsp;
                </button>
            </div>
            <br>
			<?php echo Html::endform();
		}
		?>
    </div>
</div>