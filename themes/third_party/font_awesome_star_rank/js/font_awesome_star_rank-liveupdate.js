jQuery(function($) {
    $('.font_awesome_star_rank_field_empty_star_icon').bind('propertychange keyup input paste', function(event) {
        $('#font_awesome_star_rank_field_empty_star_icon').html('<i class=\"icon-$(this).val()\"></i>');
    });
	$('.font_awesome_star_rank_field_half_star_icon').bind('propertychange keyup input paste', function(event) {
        $('#font_awesome_star_rank_field_half_star_icon').html('<i class=\"icon-$(this).val()\"></i>');
    });
	$('.font_awesome_star_rank_field_full_star_icon').bind('propertychange keyup input paste', function(event) {
        $('#font_awesome_star_rank_field_full_star_icon').html('<i class=\"icon-$(this).val()\"></i>');
    });
});