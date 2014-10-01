<?php foreach ($comments as $comment): ?>
<div class="comment" id="c<?php $comment->id; ?>">

	<?php echo CHtml::link(
		"#{$comment->id}", $comment->getUrl($post), array(
			'class' => 'cid',
			'title' => 'Permalink to this comment'
		));?>

	<div class="author">
		<?php echo $comment->author ?>
	</div>

	<div class="time">
		<?php echo $comment->create_time; ?>
	</div>

	<div class="content">
		<?php echo nl2br(CHtml::encode($comment->content)); ?>
	</div>
</div>
<?php endforeach; ?>