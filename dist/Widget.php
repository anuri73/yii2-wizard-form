<?php
/**
 * Created by PhpStorm.
 * User: Urmat
 * Date: 05.06.2017
 * Time: 8:21
 */

namespace anuri73\wzard;

use yii\bootstrap\Html;
use yii\bootstrap\Widget as BaseWidget;
use yii\helpers\ArrayHelper;

/**
 * Class Widget
 * @package anuri73\wzard
 */
class Widget extends BaseWidget {
	#region Options
	/**
	 * List of items in the nav widget. Each array element represents a single menu item which can be either a string or an array with the following structure:
	 * @var array $items
	 */
	public $items = [];
	/**
	 * Active index
	 * @var int $active_index
	 */
	public $active_index = 0;
	#endregion

	#region Protected methods
	/**
	 * @var array $default_options
	 */
	protected $default_options = [
		'encode'      => false,
		'class'       => 'nav nav-tabs',
		'role'        => 'tablist',
		'itemOptions' => [
			'role' => 'presentation'
		],
	];
	#endregion

	#region Core
	/** @inheritdoc */
	function run() {
		$this->registerAssets();

		return Html::tag( 'div', implode( array_filter( [
			$this->renderNavigation( ArrayHelper::getValue( $this->options, 'label', [] ) ),
			$this->renderPanes(),
		] ) ), [ 'class' => 'wizard' ] );
	}
	#endregion

	#region Protected methods
	/**
	 * Render tab panes
	 * @return string
	 */
	protected function renderPanes() {
		$items = ArrayHelper::getColumn( $this->items, 'item' );

		return Html::tag(
			'div',
			implode( array_filter( array_map( function ( $item, $index ) {
				return Html::tag( 'div', $item, [
					'class' => implode( " ", array_filter( [
						'tab-pane',
						$this->active_index == $index ? 'active' : false,
					] ) ),
					'role'  => 'tabpanel',
					'id'    => $this->getPaneId( $index )
				] );
			}, $items, array_keys( $items ) ) ) ), [
			'class' => 'tab-content'
		] );
	}

	/**
	 * Render navigation bar
	 *
	 * @param array $options
	 *
	 * @return string
	 */
	protected function renderNavigation( array $options = [] ) {

		if ( ! array_key_exists( 'item', $options ) ) {
			$options['item'] = function ( $item, $index ) {
				return $this->renderNavigationItem( $item, $index );
			};
		}

		return Html::tag(
			'div',
			Html::ul(
				ArrayHelper::getColumn( $this->items, 'label' ),
				ArrayHelper::merge( $this->default_options, $options )
			),
			[ 'class' => 'wizard-inner', ]
		);
	}

	/**
	 * Register assets
	 * @return Asset
	 */
	protected function registerAssets() {
		return Asset::register( $this->view );
	}

	/**
	 * Render navigation item
	 *
	 * @param mixed $item
	 * @param int $index
	 *
	 * @return string
	 */
	protected function renderNavigationItem( $item, $index ) {

		$options = ArrayHelper::getValue( $this->options, 'itemOptions', [] );

		if ( $index == $this->active_index ) {
			Html::addCssClass( $options, 'active' );
		}

		return Html::tag(
			'li',
			Html::a(
				$item,
				"#{$this->getPaneId($index)}",
				[
					'data'          => [ 'toggle' => 'tab' ],
					'aria-controls' => $this->getPaneId( $index ),
					'role'          => 'tab',
					'title'         => strip_tags( $item )
				]
			),
			$options
		);
	}

	/**
	 * Get pane id by the index
	 *
	 * @param mixed $index
	 *
	 * @return mixed string
	 */
	protected function getPaneId( $index ) {
		return "{$this->id}-pane-{$index}";
	}
	#endregion
}