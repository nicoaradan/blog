<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
    $model->title => array('view', 'id' => $model->id_tbl_post),
	'Update',
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
    array('label' => 'View Post', 'url' => array('view', 'id' => $model->id_tbl_post)),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

    <h1>Update Post <?php echo $model->id_tbl_post; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>