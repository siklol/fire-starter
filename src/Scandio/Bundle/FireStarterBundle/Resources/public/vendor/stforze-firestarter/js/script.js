



$(document).ready(function(){
	$('.box').mouseenter(function(){
		$( '.content', this ).animate({
		  top: 0
		},{duration:'fast'});
	}).mouseleave(function(){
		var headineHeight = $('.box h1').css('height');
		headineHeight = headineHeight.replace('px');
		headineHeight = parseInt(headineHeight);
		var currentHeight = $(this).height() - headineHeight;
		
		$( '.content', this ).animate({
		  top: currentHeight
		},{duration:'slow'});
	});
	
	resizeBoxes();
});


$(window).resize(function(){
	resizeBoxes();
});


function resizeBoxes () {
	var headineHeight = $('.box h1').css('height');
	headineHeight = headineHeight.replace('px');
	headineHeight = parseInt(headineHeight);
	var currentHeight = $('.box').height() - headineHeight;
	$( '.box .content').css({top:currentHeight}); 
}