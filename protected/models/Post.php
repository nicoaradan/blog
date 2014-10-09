<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Comment $comment
 * @property User $id0
 */
class Post extends CActiveRecord
{

	const STATUS_DRAFT = 1;
	const STATUS_PUBLISHED = 2;
	const STATUS_ARCHIVED = 3;
	private $_oldTags;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 *
	 * @return Post the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, status', 'required'),
			array('status', 'numerical', 'integerOnly' => true,),
			array('status', 'in', 'range' => array(1, 2, 3)),
			array('title', 'length', 'max' => 200),
			array(
				'tags',
				'length',
				'max' => 100,
				'message' => 'Tags can only contain word characters.'
			),
			array(
				'tags',
				'match',
				'pattern' => '/^[\w\s,]+$/'
			),
			array('tags', 'normalizeTags'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('title, status', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'author' => array(self::BELONGS_TO, 'User', 'id'),
			'comment' => array(
				self::HAS_MANY,
				'Comment',
				'post_id',
				'condition' => 'comment.status=' . Comment::STATUS_APPROVED,
				'order' => 'comment.create_time DESC'
			),
			'commentCount' => array(
				self::STAT,
				'Comment',
				'post_id',
				'condition' => 'status=' . Comment::STATUS_APPROVED
            ),
            'mapStatus' => array(self::BELONGS_TO, 'Lookup', 'status')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id_tbl_post' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

        $criteria->compare('id_tbl_post', $this->id_tbl_post, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('tags', $this->tags, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		return new CActiveDataProvider(
			$this, array(
				'criteria' => $criteria,
			));
	}

	/**
	 * @param $attribute
	 * @param $params
	 */
	public function normalizeTags($attribute, $params)
	{
		$this->tags = Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	/**
	 * @return mixed - A SEO friendly URL.
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl(
			'post/view', array(
                'id' => $this->id_tbl_post,
				'title' => $this->title,
			));
	}

    /**
     * @param $comment
     *
     * @return mixed
     */
	public function addComment($comment)
	{
		if (Yii::app()->params['commentNeedApproval']) {
			$comment->status = Comment::STATUS_PENDING;
		}
		else {
			$comment->status = Comment::STATUS_APPROVED;
		}

        $comment->post_id = $this->id_tbl_post;

		return $comment->save();
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {

			$time = new DateTime();

			if ($this->isNewRecord) {
                $this->fk_tbl_user = Yii::app()->id;
			}

			$this->update_time = $time->date;

			return true;
		}
		else {
			return false;
		}
	}

	protected function afterSave()
	{
		parent::afterSave();
		Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags = $this->tags;
	}
}
