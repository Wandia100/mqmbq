function runDraw () {
    // alert(saleid);
    $('##winner_draw').modal({
      backdrop: 'static',
      keyboard: false
    })
  
    $('#winner_draw .modal-dialog').addClass('modal-lg')
    $('#winner_draw .modal-dialog').addClass('largerwidth')
    $('#sale_datum').html('Receipt for sale no:')

  }