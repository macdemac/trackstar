<?php
/**
 * Created by JetBrains PhpStorm.
 * User: macdemac
 * Date: 27/02/12
 * Time: 7:52 PM
 * To change this template use File | Settings | File Templates.
 */
class IssueTest extends CDbTestCase
{
	public $fixtures = array(
		'projects' => 'Project',
		'issues' => 'Issue',
	);

	public function testGetTypes()
	{
		$options = Issue::model()->getTypeOptions();
		$this->assertTrue(is_array($options));
		$this->assertTrue(3 == count($options));
		$this->assertTrue(in_array('Bug', $options));
		$this->assertTrue(in_array('Task', $options));
		$this->assertTrue(in_array('Feature', $options));
	}

	public function testGetStatus()
	{
		$status = Issue::model()->getStatusOptions();
		$this->assertTrue(is_array($status));
		$this->assertTrue(3 == count($status));
		$this->assertTrue(in_array('Not yet started', $status));
		$this->assertTrue(in_array('Started', $status));
		$this->assertTrue(in_array('Finished', $status));
	}

	public function testGetStatusText()
	{
		$this->assertTrue('Started' == $this->issues('issueBug')->getStatusText());
	}

	public function testGetTypeText()
	{
		$this->assertTrue('Bug' == $this->issues('issueBug')->getTypeText());
	}
}