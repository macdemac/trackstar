<?php

Yii::import('application.controllers.MessageController');

	/**
 * Created by JetBrains PhpStorm.
 * User: macdemac
 * Date: 25/02/12
 * Time: 9:02 PM
 * To change this template use File | Settings | File Templates.
 */
class MessageTest extends CTestCase
{
	public function testRepeat()
	{
		$message = new MessageController('messageTest');
		$this->assertEquals($message->repeat("Hello, anyone out there!"), "Hello, anyone out there!");
	}
}