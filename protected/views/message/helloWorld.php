<?php
$this->breadcrumbs=array(
	'Message'=>array('message/index'),
	'HelloWorld',
);?>
<h1>Hello World!</h1>
<h3><?php echo $time; ?> </h3>
<a><?php echo CHtml::link("Goodbye", array('message/goodbye')); ?></a>

<p>You may change the content of this page by modifying the file <tt><?php echo __FILE__; ?></tt>.</p>
