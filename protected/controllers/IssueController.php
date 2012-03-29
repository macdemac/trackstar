<?php

class IssueController extends Controller
{
	/*
	 * @var private property containing the associated Project model instance
	 */
	private $_project = null;

	/**
	 * Protected method to laod the associated Project model class
	 * @project_id the primary identifier of the associated Project
	 * @return object the Project data model based on the primary key
	 */
	private function loadProject($project_id)
	{
		// if the $project_id is null then created it based upon the input
		if ($this->_project === null)
		{
			$this->_project = Project::model()->findByPk($project_id);
			if ($this->_project === null)
			{
				throw new CHttpException(404, 'The requested project id does not exist.');
			}
		}

		return $this->_project;
	}

	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'projectContext + create index admin', // check to ensure valid project context
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
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Issue;

		// add the relevant project id
		$model->project_id = $this->_project->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Issue']))
		{
			$model->attributes=$_POST['Issue'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Issue']))
		{
			$model->attributes=$_POST['Issue'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = $this->loadModel();

		$dataProvider=new CActiveDataProvider('Issue', array(
				'criteria' => array(
					'condition' => 'project_id=:projectId',
					'params' => array(':projectId' => $this->_project->id),
					//'params' => array(':projectId' => $model->project_id),
				),
		));

		$this->render('index', array('dataProvider'=>$dataProvider, 'model' => $model));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Issue('search');
		if(isset($_GET['Issue']))
			$model->attributes=$_GET['Issue'];

		$model->project_id = $this->_project->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Issue::model()->findbyPk($_GET['id']);

			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='issue-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function filterProjectContext($filterChain)
	{
		// set the project identifier based on the GET or POST input
		// request variables, since we allow both in our actions
		$projectId = null;

		if (isset($_GET['pid']))
			$projectId = $_GET['pid'];
		else
		    if (isset($_POST['pid']))
			    $projectId = $_POST['pid'];

//		if ($projectId != null)
			$this->loadProject($projectId);
//		else
//			throw new CHttpException(404, 'No project selected');

		$filterChain->run();
	}
}
