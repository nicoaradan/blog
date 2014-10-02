<?php
/**
 * Created by PhpStorm.
 * User: d.nicoara
 * Date: 01/10/14
 * Time: 15:27
 */

Yii::import('zii.widgets/CPortlet.php');

class UserMenu extends CPortlet
{
	/**
	 * Initialize the title of the UserMenu and also calls the init method from CPortlet
	 */
	public function init()
	{
		$this->title = CHtml::encode(Yii::app()->user->name);
		parent::init();
	}

	/**
	 * Renders the content of the portlet
	 * @throws CExceptionRenders
	 */
	protected function renderContent()
	{
		$this->render('userMenu');
	}
} 