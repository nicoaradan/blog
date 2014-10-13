<?php foreach ($comments as $comment): ?>
    <?php if (($comment->post_id == $post->id_tbl_post) &&
        ($comment->status == Comment::STATUS_APPROVED)
    ): ?>
        <div class="comment" id="c<?php $comment->id; ?>">

            <?php echo CHtml::link(
                "#{$comment->id}", $comment->getUrl(), array(
                    'class' => 'cid',
                    'title' => 'Permalink to this comment'
                ));?>

            <div class="author">
                <?php echo CHtml::encode($comment->author); ?>
            </div>

            <div class="time">
                <?php echo CHtml::encode($comment->create_time); ?>
            </div>

            <div class="content">
                <?php echo CHtml::encode($comment->content); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>