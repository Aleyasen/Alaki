<?php

Yii::import('application.models._base.BaseUserActivity');

class UserActivity extends BaseUserActivity
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}