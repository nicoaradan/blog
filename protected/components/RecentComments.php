<?php

/**
 * Created by PhpStorm.
 * User: d.nicoara
 * Date: 02/10/14
 * Time: 11:38
 */
class RecentComments extends CPortlet
{

	public $title       = 'Recent Comments';
	public $maxComments = 10;

	public function getRecentComments()
	{
		return Comment::model()->findRecentComments($this->maxComments);
	}

	protected function renderContent()
	{
		$this->render('recentComments');
	}
}