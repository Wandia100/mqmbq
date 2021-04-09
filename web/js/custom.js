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
   $('.modal-backdrop').hide();
   $('#draw_winner_modal').on('hidden.bs.modal', function () {
    location.reload();
  })

  }
  function drawPrize(station_show_id,presenter_id,prize_id)
  {
    $.post(host + '/winninghistories/draw', {station_show_id: station_show_id, presenter_id: presenter_id,prize_id:prize_id}, function (data) {
      //$('#actionsviewgrid').text('')
      //$('#actionsviewgrid').append(data).trigger('create')
      var data=JSON.parse(data);
      if(data.status=="fail")
      {
        $('#winner_number').html("0 0 0 0 0 0 0 0 0 0 0 0")
        $('#winner_name').html(data['message'])
      }
      else{
        $('#winner_number').html(data.data.reference_phone)
        $('#winner_name').html(data.data.reference_name)
        if(data.data.draw_count_balance==0)
        {
          document.getElementById(prize_id).disabled=true;
        }
        
      }
      //console.log( typeof data)
      console.log(data)
    })
    //console.log("You clicked "+presenter_id)
  }