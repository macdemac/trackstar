<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: macdemac
	 * Date: 26/03/12
	 * Time: 3:38 PM
	 * To change this template use File | Settings | File Templates.
	 */
	abstract class TrackStarActiveRecord extends CActiveRecord
	{
		/**
		 * Prepares the create_time, create_user_id, update_time and update_user_id attributes before performing validation
		 */
		protected function beforeValidate()
		{
			if ($this->isNewRecord)
			{
				// Set the update_time and update_user_id as they will always be set
				$this->create_time = $this->update_time = new CDbExpression('NOW()');
				$this_create_user_id = $this->update_user_id = Yii::app()->user->id;
			}
			else
			{
				$this->update_time = new CDbExpression('NOW()');
				$this->update_user_id = Yii::app()->user->id;
			}

			return parent::beforeValidate();
		}
	}
