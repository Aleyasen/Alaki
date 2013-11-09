<?php

Yii::import('application.models._base.BaseSchool');

class School extends BaseSchool
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}