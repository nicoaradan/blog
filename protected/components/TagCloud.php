<?php

/**
 * Created by PhpStorm.
 * User: d.nicoara
 * Date: 02/10/14
 * Time: 09:28
 */
class TagCloud extends CPortlet
{

    public $title   = 'Tags';
    public $maxTags = 20;

    protected function renderContent()
    {
        $tags = Tag::model()->findTagWeights($this->maxTags);

        foreach ($tags as $tag => $weight) {
            $link = CHtml::link(CHtml::encode($tag), array('post/index', 'tag' => $tag));
            echo CHtml::tag(
                'span', array(
                    'class' => 'tag',
                    'style' => "font-size:{$weight}pt"
                ), $link . "\n");
        }
    }
}