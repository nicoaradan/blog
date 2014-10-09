<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
    array('label' => 'Update Post', 'url' => array('update', 'id' => $model->id_tbl_post)),
    array(
        'label' => 'Delete Post',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id_tbl_post),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<h1>View Post #<?php echo $model->id_tbl_post; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'id_tbl_post',
		'title',
		'content',
		'tags',
		'status',
		'create_time',
		'update_time',
	),
)); ?>

<div id="comments">
	<?php if ($model->commentCount >= 1): ?>
		<h3>
			<?php echo $model->commentCount . ' comment(s)'; ?>
		</h3>

		<?php $this->renderPartial(
			'_comments', array(
				'post' => $model,
				'comments' => $comments
			)); ?>
	<?php endif; ?>

	<h3>Leave a comment</h3>
	<?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
		</div>
	<?php else: ?>
		<?php $this->renderPartial(
			'/comment/_form', array(
				'model' => new Comment()
			)); ?>

	<?php endif; ?>
</div>