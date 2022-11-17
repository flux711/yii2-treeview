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
 * 				'collapsed' => true,
 *              'content' => [
 * 					'key => 'value'
 * 					'url' => '...'
 * 				],
 *              'children' => [
 *              	'content' => [
 * 						[
 * 							'key => 'value'
 *	 						'url' => '...'
 * 						],
 * 					],
 * 					'collapsed' => true,
 * 					'children => [...],
 *              ],
 *          ],
 *      ]
 * ]);
 *
 */
class TreeView extends Widget
{
	public $tree = [];

	public $defaultCollapsed = false;

	public function run()
	{
		$view = $this->getView();

		TreeViewAssets::register($view);

		echo '<div id="'.$this->id.'" class="w-treeview">';
		if(count($this->tree) > 0)
		{
			echo '<ul>';
			echo $this->_renderLeaf($this->tree);
			echo '</ul>';
		}
		echo '</div>';

		$view->registerJs('treeview.init();');
	}

	private function _renderLeaf($leaf)
	{
		$out = '';
		foreach ($leaf as $node)
		{
			$content = '';
			$iconTag = '';
			$childrenContent = '';

			if(!isset($node['collapsed'])) $node['collapsed'] = $this->defaultCollapsed;
			$node['itemOptions'] = [];
			$node['itemOptions']['class'] = '';
			if($node['collapsed'] == false) $node['itemOptions']['class'] .= ' w-treeview-expanded';

			if(!isset($node['children'])) $node['children'] = [];
			$node['itemOptions']['hasChildren'] = false;
			if(count($node['children']) > 0)
			{
				$node['itemOptions']['hasChildren'] = true;
				$node['itemOptions']['class'] .= ' w-treeview-has-children';
				$iconTag = $node['collapsed'] ? MD::icon(MD::_ADD_CIRCLE_OUTLINE) : MD::icon(MD::_REMOVE_CIRCLE_OUTLINE);
				$childrenContent = Html::tag('ul', $this->_renderLeaf($node['children']));
			}

			for ($i = 0; $i < sizeof($node['content']); $i++) {
				if ($i != 0 || !$node['itemOptions']['hasChildren'])
					$content .= Html::tag('span', '', ['class' => 'w-treeview-content-span']);
				foreach ($node['content'][$i] as $key => $value) {
					if ($key == 'url') continue;

					$label = Html::tag('span', $key.': ');

					if (isset($node['content'][$i]['url']))
						$content .= $label.Html::a($value, $node['content'][$i]['url']);
					else
						$content .= $label.Html::tag('span', $value);;
				}
				$content .= '<br>';
			}

			$content .= $childrenContent;

			$out .= Html::tag('li', Html::tag('span', $iconTag, $node['itemOptions']['hasChildren'] ? ['class' => 'w-treeview-caret '] : []).$content, $node['itemOptions']);
		}

		return $out;
	}
}
