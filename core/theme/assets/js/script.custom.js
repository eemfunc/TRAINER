(function ($) {
    $(window).on("load", function () {
		$(".loader").fadeOut();
		$("#preloader").delay(300).fadeOut("fast");
	});
})(jQuery);

function goto(x){
    $(".loader").fadeIn();
    $("#preloader").fadeIn("fast");
    setTimeout(
        function(){window.location.href=x;}, 
        300
    );
}

function doAlr(l, m){
    if (confirm(m))
        goto(l);
}