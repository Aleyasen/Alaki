<?php

Yii::import('application.models._base.BaseEvents');

class Events extends BaseEvents
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}