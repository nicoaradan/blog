<ul>
    <li><?php echo CHtml::link('Create new Post', array('post/create')); ?></li>
    <!-- TODO modify this using roles from Yii framework -->
    <?php if (Yii::app()->user->name == 'demo'): ?>
    <li><?php echo CHtml::link('Manage posts', array('post/admin')); ?></li>
    <li><?php echo CHtml::link('Manage comments', array('comment/index')); ?></li>
    <?php endif; ?>
    <li><?php echo CHtml::link('Logout', array('site/logout')); ?></li>
</ul>