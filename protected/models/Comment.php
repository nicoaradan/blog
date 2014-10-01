<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property string $id
 * @property string $content
 * @property integer $status
 * @property string $create_time
 * @property string $author
 * @property string $email
 * @property string $url
 *
 * The followings are the available model relations:
 * @property Post $id0
 */
class Comment extends CActiveRecord
{
	const STATUS_PENDING = 1;
	const STATUS_APPROVED = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 *
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, author, email', 'required'),
			array('status', 'numerical', 'integerOnly' => true),
			array('author', 'length', 'max' => 50),
			array('email', 'length', 'max' => 100),
			array('url', 'length', 'max' => 200),
			array('url', 'url'),
			array('email', 'email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('status, author, email', 'safe', 'on' => 'search'),
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
			'post' => array(self::BELONGS_TO, 'Post', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'author' => 'Author',
			'email' => 'Email',
			'url' => 'Website',
			'post_id' => 'Post'
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

		$criteria->compare('id', $this->id, true);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('author', $this->author, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('url', $this->url, true);

		return new CActiveDataProvider(
			$this, array(
				'criteria' => $criteria,
			));
	}

	public function approve()
	{
		$this->status = Comment::STATUS_APPROVED;
		$this->update(array('status'));
	}

	/**
	 * @param Post the post that this comment belongs to. If null, the method
	 * will query for the post.
	 *
	 * @return string the permalink URL for this comment
	 */
	public function getUrl($post = null)
	{
		if ($post === null) {
			$post = $this->post;
		}

		return $post->url . '#c' . $this->id;
	}

	/**
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (parent::BeforeSave()) {
			if ($this->isNewRecord) {
				$time = new DateTime();
				$this->create_time = $time->date;
			}
			return true;
		}
		else {
			return false;
		}
	}
}
