<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Posts',
);

$this->menu=array(
    array('label' => 'Create Post', 'url' => array('create'))
);

if (Yii::app()->user->name == 'demo') {
    array_push($this->menu, array('label' => 'Manage Post', 'url' => array('admin')));
}

?>

<h1>Posts</h1>

<?php if (!empty($_GET['tag'])): ?>
    <h1>Post tag with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'template' => '{items}{pager}',
    'itemsCssClass' => 'panel-default panel',
    'htmlOptions' => array('id' => 'accordion', 'class' => 'panel-group'),
    'emptyText' => 'No Post present'
)); ?>
