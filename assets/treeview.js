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
				ul.stop().slideUp(300, function(){li.removeClass('w-treeview-expanded')});
			}
			else
			{
				ul.stop().slideDown(300, function(){li.addClass('w-treeview-expanded')});
			}
			e.preventDefault();
		})
	}
};