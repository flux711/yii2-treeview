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
			let caret = $(this);
			let li = $(caret.parents('li')[0]);
			let ul = li.find('>ul');
			if(li.hasClass('w-treeview-expanded'))
			{
				let i = $(caret.children('i')[0]);
				i.removeClass('mdi-remove-circle-outline')
				i.addClass('mdi-add-circle-outline');
				ul.stop().slideUp(100, function(){li.removeClass('w-treeview-expanded')});
			}
			else
			{
				let i = $(caret.children('i')[0]);
				i.removeClass('mdi-add-circle-outline')
				i.addClass('mdi-remove-circle-outline');
				ul.stop().slideDown(100, function(){li.addClass('w-treeview-expanded')});
			}
			e.preventDefault();
		})
	}
};
