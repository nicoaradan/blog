<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users' => array('demo'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    /**
     * Displays a particular model.
     *
     * @param $id - The id of the Post.
     *
     * @throws CHttpException
     * @throws Exception
     */
    public function actionView($id)
	{
        if (!empty($id)) {
            $post = $this->loadModel($id);

            $comments = $this->getComments($post);

            $this->render(
                'view', array(
                    'model' => $post,
                    'comments' => $comments
                ));

        } else {
            throw new Exception('Post with not found');
        }
	}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param $id - Id of the Post.
     *
     * @throws CHttpException
     * @return Post the loaded model
     */
    public function loadModel($id)
	{
		if ($this->_model === null)
		{
            if (isset($id))
			{
				$condition = '';
				if (Yii::app()->user->isGuest){
					$condition = 'status=' . Post::STATUS_PUBLISHED . ' OR status=' . Post::STATUS_ARCHIVED;
				}

                $this->_model = Post::model()->findByPk($id, $condition);

				if ($this->_model === null)
				{
					throw new CHttpException(404, 'The requested page does not exist.');
				}
			}
		}
		return $this->_model;
	}

    /**
     * @param $post
     * TODO - creation of the comments.
     *
     * @return array|CActiveRecord|CActiveRecord[]|Comment|mixed|null
     */
	protected function getComments($post)
	{
        $comment = new Comment();


		if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}

		if (isset($_POST['Comment'])) {
			$comment->attributes = $_POST['Comment'];
			if ($post->addComment($comment)) {
				if ($comment->status == Comment::STATUS_PENDING) {
					Yii::app()->user->setFlash(
						'commentSubmitted',
						'Thank you for your comment. Your comment will be posted once it is approved.');
				}
				$this->refresh();
			}
			$comment = array($comment);
            // TODO - better separation of information between entities.
		}
		else {
            $comment = Comment::model()->findAll('post_id', array($post->id_tbl_post));
		}

		return $comment;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $model = new Post();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
                $this->redirect(array('view', 'id' => $model->id_tbl_post));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
                $this->redirect(array('view', 'id' => $model->id_tbl_post));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria(array(
            //'condition' => 'status=' . Post::STATUS_PUBLISHED,
			'order' => 'update_time DESC',
			'with' => 'commentCount'
		));
		if (isset($_GET['tag']))
			$criteria->addSearchCondition('tags', $_GET['tag']);

		$dataProvider = new CActiveDataProvider('Post', array(
			'pagination' => array(
				'pageSize' => 5
			),
			'criteria' => $criteria
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll('post_id=', $this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}
}
