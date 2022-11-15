<?php

namespace flux711\treeview;

use yii\helpers\Html;
use \yii\base\Widget;
use yii\materialicons\MD;

/**
 * Class TreeView
 *
 * ```php
 * TreeView::widget([
 *      'defaultCollapsed' => true,
 *      'items' => [
 *          [
 *              'caption' => 'Item 1',
 *              'content' => [
 * 					'caption => 'Content of Item 1'
 * 					'url' => '...'
 * 				],
 *              'collapsed' => true,
 *              'url' => '...',
 *              'children' => [
 *                  [...]
 *              ]
 *          ],
 *      ]
 * ]);
 *
 * @author        Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 */
class TreeView extends Widget
{
	public $items = [];

	public $defaultCollapsed = false;

	public function run()
	{
		$view = $this->getView();

		TreeViewAssets::register($view);

		echo '<div id="'.$this->id.'" class="w-treeview">';
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
			$iconTag = '';
			$childrenContent = '';
			if(!isset($item['caption'])) continue;

			$item['items'] = isset($item['items']) ? $item['items'] : [];

			if(!isset($item['collapsed'])) $item['collapsed'] = $this->defaultCollapsed;
			if($item['collapsed'] == false) $item['itemOptions']['class'] .= ' w-treeview-expanded';

			if(!isset($item['children'])) $item['children'] = [];
			if(count($item['children']) > 0)
			{
				$item['itemOptions']['class'] .= ' w-treeview-has-children';
				$iconTag = $item['collapsed'] ? MD::icon(MD::_ADD_CIRCLE_OUTLINE) : MD::icon(MD::_REMOVE_CIRCLE_OUTLINE);
				$childrenContent = Html::tag('ul', $this->_renderLeaf($item['children']));
			}

			$label = Html::tag('span', $item['caption']);

			if(isset($item['url']))
				$content .= Html::a($label, $item['url'], $item['linkOptions']);
			else
				$content .= $label;

			if(isset($item['label'])) $content .= Html::tag('span', $item['label'], ['class' => 'label label-default']);
			$content .= $childrenContent;

			$out .= Html::tag('li', Html::tag('span', $iconTag, ['class' => 'w-treeview-caret ']).$content, $item['itemOptions']);
		}
		return $out;
	}
}
