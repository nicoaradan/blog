<ul>
	<?php foreach ($this->getRecentComments() as $comment): ?>
		<li>
			<?php echo $comment->content; ?>
			<?php echo $comment->getAuthorLink(); ?> on <?php echo CHtml::link(
				$comment->post->title, $comment->getUrl()); ?>
		</li>
	<?php endforeach; ?>
</ul>