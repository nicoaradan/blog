<?php
/* @var $this PostController */
/* @var $data Post */
?>

<div class="panel-heading">
    <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $data->id_tbl_post; ?>">
            <?php echo CHtml::encode($data->title); ?>
        </a>
    </h4>
</div>
<div id="<?php echo $data->id_tbl_post; ?>" class="panel-collapse collapse">
    <div class="panel-body">
        <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
        <?php echo CHtml::encode($data->title); ?>
        <br/>

        <b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
        <?php echo CHtml::encode($data->content); ?>
        <br/>

        <b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
        <?php echo CHtml::encode($data->tags); ?>
        <br/>

        <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
        <?php echo CHtml::encode($data->mapStatus->name); ?>
        <br/>

        <b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
        <?php echo CHtml::encode($data->create_time); ?>
        <br/>

        <b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
        <?php echo CHtml::encode($data->update_time); ?>
        <br/>
    </div>
</div>