$(function(){
    $(document).on('click', '.showModalButton', function(){
        triggerModal($(this));        
    });
});

function triggerModal(e)
{
    if ($('#main-modal').hasClass('in')) {
        $('#main-modal').find('#modalContent')
                .load(e.attr('value'));
        document.getElementById('main-modalmodalHeader')
                .innerHTML = '<h4>' + e.attr('title') + '</h4>';
    } else {
        $('#main-modal').modal('show')
                .find('#modalContent')
                .load(e.attr('value'));
        document.getElementById('main-modalmodalHeader')
                .innerHTML = '<h4>' + e.attr('title') + '</h4>';
    }
}