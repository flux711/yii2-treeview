<?php
/**
 * @copyright (C) FIT-Media.com (fit-media.com), {@link http://tanitacms.net}
 * Date: 11.06.15, Time: 0:27
 *
 * @author        Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * @package
 */

namespace m00nk\treeview;

use yii\helpers\Html;
use yii\helpers\Json;
use \yii\base\Widget;

class TreeView extends Widget
{
	/*
		[
			[
				'caption' => 'Item 1',
				'label' => 'label for item 1',
				'collapsed' => true,
				'itemOptions' => [], // атрибуты для тега LI (здесь можно указать, например, класс для ACTIVE, значение data-id и т.д.)
				'icon' => '...', // URL иконки или FALSE если не нужна
				'url' => '...',
				'linkOptions' => [], // атрибуты тега A
				'children' => [
					[...]
				]
			], ...
		]
	 */
	public $items = [];

	public $defaultCollapsed = false;

	public function run()
	{
		$view = $this->getView();

		TreeViewAssets::register($view);

		echo '<div class="treeview">';
		if(count($this->items) > 0)
		{
			echo '<ul>';
			echo $this->_renderLeaf($this->items);
			echo '</ul>';
		}
		echo '</div>';

		$view->registerJs('treeview.init();');
	}

	private function _renderLeaf($leaf)
	{
		$out = '';
		foreach ($leaf as $item)
		{
			$content = '';
			$childrenContent = '';
			if(!isset($item['caption'])) continue;

			$item['linkOptions'] = isset($item['linkOptions']) ? $item['linkOptions'] : [];
			$item['itemOptions'] = isset($item['itemOptions']) ? $item['itemOptions'] : [];
			$item['icon'] = isset($item['icon']) ? $item['icon'] : false;
			if(!isset($item['itemOptions']['class'])) $item['itemOptions']['class'] = '';

			if(!isset($item['collapsed'])) $item['collapsed'] = $this->defaultCollapsed;
			if($item['collapsed'] == false) $item['itemOptions']['class'] .= ' treeview-expanded';

			if(!isset($item['children'])) $item['children'] = [];
			if(count($item['children']) > 0)
			{
				$item['itemOptions']['class'] .= ' treeview-has-children';
				$childrenContent = Html::tag('ul', $this->_renderLeaf($item['children']));
			}

			$label = ($item['icon']!==false ? Html::img($item['icon'], ['class' => 'treeview-icon']) : '').Html::tag('span', $item['caption']);

			if(isset($item['url']))
				$content .= Html::a($label, $item['url'], $item['linkOptions']);
			else
				$content .= $label;

			if(isset($item['label'])) $content .= Html::tag('span', $item['label'], ['class' => 'label label-default']);
			$content .= $childrenContent;

			$out .= Html::tag('li', Html::tag('span', '', ['class' => 'treeview-caret']) . $content, $item['itemOptions']);

		}
		return $out;
	}
}