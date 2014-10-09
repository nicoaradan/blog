<ul>
	<li><?php echo CHtml::link('Create new Post', array('post/create')); ?></li>
	<li><?php echo CHtml::link('Manage posts', array('post/admin')); ?></li>
    <li><?php echo CHtml::link('Manage comments', array('comment/index')); ?></li>
	<li><?php echo CHtml::link('Logout', array('site/logout')); ?></li>
</ul>