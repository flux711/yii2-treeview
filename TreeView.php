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
 *      'defaultCollapsed' => bool,
 * 		'emptyMessage' => string,
 *      'tree' => [
 *          [
 * 				'collapsed' => bool,
 *              'content' => [
 * 					'key => 'value'
 * 					'url' => '...'
 * 				],
 *              'children' => [
 *              	'content' => [
 * 						// content can also contain an array of contents, which will be displayed as a simple space separated list
 * 						'key' => [
 * 							[
 * 								'0 => 'value'
 *	 							'url' => '...'
 * 							],
 * 						],
 * 					],
 * 					'collapsed' => bool,
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

	public $emptyMessage = '';

	public $defaultCollapsed = false;

	public function run()
	{
		$view = $this->getView();

		TreeViewAssets::register($view);

		echo '<div id="'.$this->id.'" class="w-treeview">';
		if(count($this->tree[0]) > 0)
		{
			echo '<ul>';
			echo $this->_renderLeaf($this->tree);
			echo '</ul>';
		} else if (!empty($emptyMessage)) {
			echo '<p>';
			echo $this->emptyMessage;
			echo '</p>';
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

				$nodeContent = $node['content'][$i];
				foreach ($nodeContent as $nodeKey => $nodeValue) {
					if ($nodeKey == 'url') continue;

					$label = Html::tag('span', '<b>'.$nodeKey.'</b>: ');

					if (is_array($nodeValue)) {
						$content .= $label;
						for ($j = 0; $j < sizeof($nodeValue); $j++) {
							if (isset($nodeValue[$j]['url']))
								$content .= Html::a($nodeValue[$j][0], $nodeValue[$j]['url']);
							else
								$content .= Html::tag('span', $nodeValue[$j][0]);
							$content .= ' ';
						}
					}
					else if (isset($nodeContent['url']))
						$content .= $label.Html::a($nodeValue, $nodeContent['url']);
					else
						$content .= $label.Html::tag('span', $nodeValue);
				}
				$content .= '<br>';
			}

			$content .= $childrenContent;

			$out .= Html::tag('li', Html::tag('span', $iconTag, $node['itemOptions']['hasChildren'] ? ['class' => 'w-treeview-caret '] : []).$content, $node['itemOptions']);
		}

		return $out;
	}
}
