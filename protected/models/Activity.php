<?php

Yii::import('application.models._base.BaseActivity');

class Activity extends BaseActivity
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}