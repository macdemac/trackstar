<?php
$this->breadcrumbs=array(
	'Issues'=>array('index'),
	'PROJECT='.$model->project->name,
);

$this->menu=array(
	array('label'=>'List Issue', 'url'=>array('index', 'pid' => $model->project_id)),
	array('label'=>'Manage Issue', 'url'=>array('admin', 'pid' => $model->project_id)),
);
?>

<h1>Create Issue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>