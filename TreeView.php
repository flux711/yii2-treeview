<?php
/**
 * @copyright (C) FIT-Media.com (fit-media.com), {@link http://tanitacms.net}
 * Date: 11.06.15, Time: 0:27
 *
 * @author        Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * @package
 */

namespace m00nk\treeview;

use yii\helpers\Json;
use \yii\base\Widget;

class TreeView extends Widget
{
	/*
		[
			[
				'label' => 'Item 1',
				'url' => '...',
				'disabled' => true,
				'children' => [
					[...]
				]
			], ...
		]
	 */
	public $items = [];

	public function run()
	{
		$view = $this->getView();

		TreeViewAssets::register($view);

//		$view->registerJs('jsk.init('.Json::encode($opts).');');
	}
}