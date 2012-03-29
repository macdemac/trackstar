<?php
/**
 * Created by JetBrains PhpStorm.
 * User: macdemac
 * Date: 27/02/12
 * Time: 11:59 AM
 * To change this template use File | Settings | File Templates.
 */

class ProjectTest extends CDbTestCase
{
	public $fixtures = array(
		'projects' => 'Project',
		'users' => 'User',
		'projUsrAssign' => ':tbl_project_user_assignment',
	);

	public function testRead()
	{
		// read back the newly created project
		$retrievedProject = $this->projects('project1');
		$this->assertTrue($retrievedProject instanceof Project);
		$this->assertEquals('Test Project 1', $retrievedProject->name);
	}

	public function testCreate()
	{
		// create a new project
		$newProject = new Project;
		$newProjectName = 'Test Project Creation';
		$newProject->setAttributes(
			array(
				'name' => $newProjectName,
				'description' => 'Test project creation for new function testCreate()',

				// 'create_time' => '2010-01-01 00:00',
				// 'create_user_id' => 1,
				// 'update_time' > '2010-01-01 00:00',
				// 'update_user_id' > 1,
			)
		);

		// set the userid to the first user in our fixture data
		Yii::app()->user->setId($this->users('user1')->id);

		$this->assertTrue($newProject->save());

		// read the project record back
		// read back the newly created project
		$retrievedProject = Project::model()->findByPK($newProject->id);
		$this->assertTrue($retrievedProject instanceof Project);
		$this->assertEquals($newProjectName, $retrievedProject->name);

		// ensure that the userid associated with the new project is the same as the application user we set when saving the project
		$this->assertEquals(Yii::app()->user->id, $retrievedProject->create_user_id);
	}

	public function testUpdate()
	{
		$project = $this->projects('project1');

		// update the newly created project
		$updatedProjectName = 'Updated Project Test 2';
		$project->name = $updatedProjectName;
		$this->assertTrue($project->save(false));

		// read back the record to ensure that the update worked
		$updatedProject = Project::model()->findByPk($project->id);
		$this->assertTrue($updatedProject instanceof Project);
		$this->assertEquals($updatedProjectName, $updatedProject->name);
	}

	public function testDelete()
	{
		$project = $this->projects('project2');
		$savedProjectId = $project->id;

		//DELETE the project
		$this->assertTrue($project->delete());
		$deletedProject = Project::model()->findByPk($project->id);
		//$this->assertTrue($deletedProject instanceof Project);
		$this->assertEquals(NULL, $deletedProject);
	}

	public function testGetUserOptions()
	{
		$project = $this->projects('project1');
		$options = $project->userOptions;

		$this->assertTrue(is_array($options));
		$this->assertTrue(count($options) > 0);
	}
}
/*
	public function testCRUD()
	{
		// create a new project
		$newProject = new Project;
		$newProjectName = 'Test Project 1';
		$newProject->setAttributes(
			array(
				'name' => $newProjectName,
				'description' => 'Test project number one',
				'create_time' => '2010-01-01 00:00',
				'create_user_id' => 1,
				'update_time' > '2010-01-01 00:00',
				'update_user_id' > 1,
			)
		);

		$this->assertTrue($newProject->save(false));

		// read back the newly created project
		$retrievedProject = Project::model()->findByPK($newProject->id);
		$this->assertTrue($retrievedProject instanceof Project);
		$this->assertEquals($newProjectName, $retrievedProject->name);

		// update the newly created project
		$updatedProjectName = 'Updated Project Test 1';
		$newProject->name = $updatedProjectName;
		$this->assertTrue($newProject->save(false));

		// read back the record to ensure that the update worked
		$updatedProject = Project::model()->findByPk($newProject->id);
		$this->assertTrue($updatedProject instanceof Project);
		$this->assertEquals($updatedProjectName, $updatedProject->name);

		//DELETE the project
		$newProjectId = $newProject->id;
		$this->assertTrue($newProject->delete());
		$deletedProject = Project::model()->findByPk($newProjectId);
		//$this->assertTrue($deletedProject instanceof Project);
		$this->assertEquals(NULL, $deletedProject);
	}
} */