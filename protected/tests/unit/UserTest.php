<?php
/**
 * Created by JetBrains PhpStorm.
 * User: macdemac
 * Date: 26/03/12
 * Time: 4:04 PM
 * To change this template use File | Settings | File Templates.
 */

class UserTest extends CDbTestCase
{
	public $fixtures = array(
		'projects' => 'Project',
		'issues' => 'Issue',
		'user' => 'User',
	);

	public function testDuplicateEmail()
	{
		// retrieve the first of the fixture users
		$testUser = $this->user('user1');

		$newUser = new User;
		$newUser->setAttributes(
			array(
				'email' => $testUser->email,
				'username' => $testUser->username,
			)
		);

		// save the record and assert that it is false
		$this->assertFalse($newUser->save());
	}

	public function testCreateUser()
	{
		$newUser = new User;
		$newUser->setAttributes(
			array(
				'email' => 'testing@gmail.com',
				'username' => 'testman',
				'pass' => 'lpgnok..'
			)
		);

		$this->assertTrue($newUser->save());
	}
}