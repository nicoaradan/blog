<?php

/**
 * Created by PhpStorm.
 * User: d.nicoara
 * Date: 10/10/14
 * Time: 16:34
 */
class ArchivedPostPortlet extends CPortlet
{
    public $limit = 10;

    /**
     * Initialize the title of the UserMenu and also calls the init method from CPortlet
     */
    public function init()
    {
        $this->title = 'Archived posts';
        parent::init();
    }

    protected function renderContent()
    {
        $archivedPosts = Post::model()->findAll('status=:status', array(':status' => Post::STATUS_ARCHIVED));

        foreach ($archivedPosts as $post) {
            $link = CHtml::link(CHtml::encode($post->title), array('post/view', 'id' => $post->id_tbl_post));
            echo CHtml::tag(
                'span', array(
                    'class' => 'post',
                ), $link . "\n");
        }
    }
} 