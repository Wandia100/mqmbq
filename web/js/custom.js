// make host varibale dynamic
if ($('#host').val() == 'localhost' && $('#port').val() == 80) {
  var host = '/' + window.location.pathname.split('/')[1] + '/web'
} else {
  var host = ''
}
function runDraw() {
    // alert(saleid);
    $('#draw_winner_modal').modal({
      //backdrop: 'static',
      //keyboard: false
    })
  
    $('#draw_winner_modal .modal-dialog').addClass('modal-lg')
    $('#draw_winner_modal .modal-dialog').addClass('largerwidth')
    $('#draw_title').html('Draw Winner')
    //var draw_prizes=$('#draw_prizes').val();
    var draw_prizes=document.getElementById("draw_prizes").innerHTML;
    console.log(draw_prizes)
   $('.modal-backdrop').hide();

  }
  function drawPrize(station_show_id,presenter_id,prize_id)
  {
    $.post(host + '/winninghistories/draw', {station_show_id: station_show_id, presenter_id: presenter_id,prize_id:prize_id}, function (data) {
      //$('#actionsviewgrid').text('')
      //$('#actionsviewgrid').append(data).trigger('create')
      console.log(data)
    })
    console.log("You clicked "+presenter_id)
  }