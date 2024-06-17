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
		if ( ! isset( $_GET['criterion'] ) || $_GET['criterion'] == 'days' ) {
			echo "class='active'";
		}
		?>
    >
        <a href="<?= yii\helpers\Url::base() ?><?= $url ?><?= $new_params ?>days"><i
                    class="fa fa-calendar-check-o"></i> Days</a></li>
                    
    <li role="presentation"
		<?php
		if ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'weeks' ) {
                    echo "class='active'";
		}
		?>
    ><a marked="1"
        href="<?= yii\helpers\Url::base() ?><?= $url ?><?= $new_params ?>weeks"><i
                    class="fa fa-calendar"></i> Weeks</a></li>
                    
    <li role="presentation"
		<?php
		if ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'months' ) {
			echo "class='active'";
		}
		?>
    ><a marked="1"
        href="<?= yii\helpers\Url::base() ?><?= $url ?><?= $new_params ?>months"><i
                    class="fa fa-calendar"></i> months</a></li>
    
</ul>
