/**
 * @copyright (C) FIT-Media.com (fit-media.com), {@link http://tanitacms.net}
 * Date: 11.06.15, Time: 1:38
 *
 * @author Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * @package
 */

var treeview = {
	init: function()
	{
		$('body').on('click', '.w-treeview .w-treeview-caret', function(e){
			var caret = $(this);
			var li = $(caret.parents('li')[0]);
			var ul = li.find('>ul');
			if(li.hasClass('w-treeview-expanded'))
			{
				li.removeClass('far fa-plus-square');
				li.addClass('far fa-minus-square');
				ul.stop().slideUp(100, function(){li.removeClass('w-treeview-expanded')});
			}
			else
			{
				li.addClass('far fa-plus-square');
				li.removeClass('far fa-minus-square');
				ul.stop().slideDown(100, function(){li.addClass('w-treeview-expanded')});
			}
			e.preventDefault();
		})
	}
};
