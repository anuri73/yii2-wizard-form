<?php
/**
 * Created by PhpStorm.
 * User: Urmat
 * Date: 01.07.2017
 * Time: 1:54
 */

namespace anuri73\wzard;

use yii\web\AssetBundle;

/**
 * Class Asset
 * @package anuri73\wzard
 */
class Asset extends AssetBundle {
	/** @inheritdoc */
	public $css = [ 'css/style.css' ];
	/** @inheritdoc */
	public $js = [];
	/** @inheritdoc */
	public $sourcePath = "@anuri73/wzard/assets";
	/** @inheritdoc */
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];
	/** @inheritdoc */
	public $publishOptions = [
		'forceCopy' => YII_DEBUG
	];
}