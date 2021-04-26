// make host varibale dynamic
if ($('#host').val() == 'localhost' && $('#port').val() == 80) {
  var host = '/' + window.location.pathname.split('/')[1] + '/web'
} else {
  var host = ''
}

$(document).ready(function(){
    
    //Auto hide flash
     $("#processbtn, .showprogressbar").on('click', function(e){
        showprogress();
    });
    commissiondisbursementModal();
});

/**
 * function to show progress bar
 * @returns {undefined}
 */
function showprogress(){
    $('#progressModal').modal('show');
    $('#cover').css('display','block');
}

function runDraw() {
    // alert(saleid);
    $('#draw_winner_modal').modal({
      //backdrop: 'static',
      //keyboard: false
    })
  
    $('#draw_winner_modal .modal-dialog').addClass('modal-lg')
    $('#draw_winner_modal .modal-dialog').addClass('largerwidth')
    $('#draw_title').html('DRAW WINNER')
   $('.modal-backdrop').hide();
   $('#draw_winner_modal').on('hidden.bs.modal', function () {
    location.reload();
  })

  }
  function drawPrize(station_show_id,presenter_id,prize_id)
  {
    var r = confirm("Are you sure you want to draw");
  if (r == true) {
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
  else
  {
    //do nothing
  }

  }
  
  function presenterModal() {
    $('#presentersModal').modal({
      //backdrop: 'static',
      //keyboard: false
    })
  
    $('#presentersModal .modal-dialog').addClass('modal-lg')
    $('#presentersModal .modal-dialog').addClass('largerwidth')
    $('.modal-backdrop').hide();
  }
  
 function commissionsModal() {
    $('#commissionsModal').modal({
      //backdrop: 'static',
      //keyboard: false
    })
  
    $('#commissionsModal .modal-dialog').addClass('modal-lg')
    $('#commissionsModal .modal-dialog').addClass('largerwidth')
    $('.modal-backdrop').hide();
  }
function prizeModal() {
    $('#prizeModal').modal({
      //backdrop: 'static',
      //keyboard: false
    })

    $('#prizeModal .modal-dialog').addClass('modal-lg')
    $('#prizeModal .modal-dialog').addClass('largerwidth')
    $('.modal-backdrop').hide();
}

function commissiondisbursementModal() {
    $('#commissiondisbursementModal').modal({
      //backdrop: 'static',
      //keyboard: false
    })

    $('#commissiondisbursementModal .modal-dialog').addClass('modal-lg')
    $('#commissiondisbursementModal .modal-dialog').addClass('largerwidth')
    $('.modal-backdrop').hide();
}


function editPrizeModal(showprizeid,draw_count,monday,tuesday,wednesday,thursday,friday,saturday,sunday,enabled) {
    $('#showprizeid').val(showprizeid)
    $('#draw_count').val(draw_count)
    $('#monday').val(monday)
    $('#tuesday').val(tuesday)
    $('#wednesday').val(wednesday)
    $('#thursday').val(thursday)
    $('#friday').val(friday)
    $('#saturday').val(saturday)
    $('#sunday').val(sunday)
    $('#enabled').val(enabled)
    
    $('.addprizespn').text('')
    $('.addprizespn').text('Edit prize')
    
    $('#prizeModal').modal({
      //backdrop: 'static',
      //keyboard: false
    })

    $('#prizeModal .modal-dialog').addClass('modal-lg')
    $('#prizeModal .modal-dialog').addClass('largerwidth')
    $('.modal-backdrop').hide();
}


/**
 *
 * @param {type} instance
 * @param {type} field
 * @param {type} id
 * @returns {undefined}
 */
function saveRecord (instance, field, id) {
    $.post(host + '/stationshowpresenters/saverecord', {value: instance.val(), field: field, id: id}, function (data) {

    })
}
/**
 *
 * @param {type} instance
 * @param {type} field
 * @param {type} id
 * @returns {undefined}
 */
function toggleDisbursement (instance, field, id) {
    $.post(host + '/disbursements/toggledisbursement', {value: instance.val(), field: field, id: id}, function (data) {

    })
}