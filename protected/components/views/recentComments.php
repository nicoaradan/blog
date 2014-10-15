<div class="list-group">
    <?php foreach ($this->getRecentComments() as $comment): ?>
        <span>
            <h4 class="list-group-item-heading"><?php echo $comment->content; ?></h4>

            <p class="list-group-item-text">
                <i><?php echo $comment->getAuthor(); ?></i>
                on <?php echo CHtml::link(
                    $comment->post->title, $comment->getUrl()); ?>
            </p>
        </span>
    <?php endforeach; ?>
</div>