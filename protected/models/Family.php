<?php

Yii::import('application.models._base.BaseFamily');

class Family extends BaseFamily
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}