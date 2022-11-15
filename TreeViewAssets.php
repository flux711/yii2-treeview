<?php
/**
 * @copyright (C) FIT-Media.com (fit-media.com), {@link http://tanitacms.net}
 * Date: 11.06.15, Time: 0:28
 *
 * @author        Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * @package
 */

namespace flux711\treeview;

use yii\web\AssetBundle;

class TreeViewAssets extends AssetBundle
{
	public $css = [
		'treeview.css'
	];

	public $js = [
		'treeview.js'
	];

	public $depends = [
		'yii\web\JqueryAsset',
		'\\yii\\materialicons\\AssetBundle'
	];

	public $publishOptions = [
		'forceCopy' => YII_ENV_DEV
	];

	public function init()
	{
		$this->sourcePath = __DIR__.'/assets';
		parent::init();
	}
}
