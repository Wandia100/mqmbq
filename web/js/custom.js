function runDraw() {
    // alert(saleid);
    $('#draw_winner_modal').modal({
      backdrop: 'static',
      keyboard: false
    })
  
    $('#draw_winner_modal .modal-dialog').addClass('modal-lg')
    $('#draw_winner_modal .modal-dialog').addClass('largerwidth')
    $('#draw_title').html('Draw Winner')

  }