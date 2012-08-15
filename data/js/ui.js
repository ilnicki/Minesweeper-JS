$(document).ready(function()
{
    moveToCenter(".centered");
    
    $(".button").mouseup(function()
    {
        $(this).css("background-position-y","-43px");
    }).mousedown(function()
    {
        $(this).css("background-position-y","-86px");
    }).mouseenter(function()
    {
        $(this).css("background-position-y","-43px");
    }).mouseleave(function()
    {
        $(this).css("background-position-y","0px");
    });
    
    $(window).resize(function()
    {
	    moveToCenter(".centered");
    });
});

function moveToCenter(element)
{
    $(element).css({
	    	"margin-left": ($(element).offsetParent().width() - $(element).width())/2,
	    	"margin-top": ($(element).offsetParent().height() - $(element).height())/2
	    });
}