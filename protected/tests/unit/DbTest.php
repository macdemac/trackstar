<?php
/**
 * Created by JetBrains PhpStorm.
 * User: macdemac
 * Date: 27/02/12
 * Time: 11:40 AM
 * To change this template use File | Settings | File Templates.
 */

class DbTest extends CTestCase
{
	public function testConnection()
	{
		$this->assertNotEquals(NULL, Yii::app()->db);
	}
}