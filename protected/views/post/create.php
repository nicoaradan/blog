<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Create',
);

$this->menu=array(
    array('label' => 'List Post', 'url' => array('index'))
);

if (Yii::app()->user->name == 'demo') {
    array_push($this->menu, array('label' => 'Manage Post', 'url' => array('admin')));
}

$this->menu = array(
    array('label' => 'List Post', 'url' => array('index'))
);
?>

<h1>Create Post</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>