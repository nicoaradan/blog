<div class="list-group">
    <?php foreach ($this->getRecentComments() as $comment): ?>
        <a href="#" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $comment->content; ?></h4>

            <p class="list-group-item-text">
                <?php echo $comment->getAuthorLink(); ?>
                on <?php echo CHtml::link(
                    $comment->post->title, $comment->getUrl()); ?>
            </p>
        </a>
    <?php endforeach; ?>
</div>