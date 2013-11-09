<?php

Yii::import('application.models._base.BaseUserLanguage');

class UserLanguage extends BaseUserLanguage
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}