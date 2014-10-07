<?php

/**
 * Created by PhpStorm.
 * User: d.nicoara
 * Date: 06/10/14
 * Time: 15:05
 */
class CommentTest extends CDbTestCase
{
	public $fixtures = array(
		'posts' => 'Post',
		'comments' => 'Comment'
	);

	/**
	 * @covers Comment::approve
	 */
	public function testApprove()
	{
		$comment = new Comment();
		$comment->setAttributes(
			array(
				'content' => 'comment 1',
				'status' => Comment::STATUS_PENDING,
				'createTime' => time(),
				'author' => 'me',
				'email' => 'me@example.com'
			), false);

		$this->assertTrue($comment->save(false));

		$comment = Comment::model()->findByPk($comment->id);
		$this->assertTrue($comment instanceof Comment);
		$this->assertEquals(Comment::STATUS_PENDING, $comment->status);

		$comment->aprove();
		$this->assertEquals(Comment::STATUS_PENDING, $comment->status);
		$comment = Comment::model()->findByPk($comment->id);
		$this->asserEquals(Comment::STATUS_APPROVED, $comment->status);
	}
}