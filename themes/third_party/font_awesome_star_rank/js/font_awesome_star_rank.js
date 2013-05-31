(function($) {
	var onDisplay = function(cell){
			$(".font_awesome_star_rank").stars({inputType:"select",split: 2});
	};
	Matrix.bind('font_awesome_star_rank', 'display', onDisplay);
})(jQuery);