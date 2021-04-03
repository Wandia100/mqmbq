(function(){
    var triggertour = new Tour({
        storage: window.localStorage,
        name: 'trigger_tour',
        onEnd: function () {
            startTour();
        }
    });
    triggertour.addSteps([
        {
            element: "#tour-step-initiate",
            placement: "bottom",
            title: "Start System Tour",
            orphan: false,
            content: "Click Next Start System Tour",
            template:`<div class='popover tour'>
                        <div class='arrow'></div>
                        <h3 class='popover-title'></h3>
                        <div class='popover-content'></div>
                        <div class='popover-navigation'>
                        <button class='btn btn-secondary' data-role='end'>Start Tour</button>
                        </div>
                      </div>`,
        }
    ]);

    triggertour.init();
    triggertour.start();

    var tour = new Tour({
        storage: window.localStorage, //turn on later
        keyboard : true, //
        name: 'system_tour',
    });

    // Gets the number of elements with class tour-step
    var numItems = $('.tour-step').length

    if(numItems > 0){
        $('.tour-step').each(function(i){
            tour.addSteps([
                {
                    element: $(this),
                    placement: "auto",
                    title: function () {
                        return $(this).attr("title") ? $(this).attr("title") : 'Tour'
                    },
                    content: function () {
                        return $(this).data('content') ? $(this).data('content') : 'Access Control Tour'
                    },
                }
            ]);
        });
    }


    // Start the tour
    function startTour(){
        // Initialize the tour
        tour.init();
        tour.start();
    }

}());