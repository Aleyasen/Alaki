<?php

Yii::import('application.models._base.BaseBook');

class Book extends BaseBook
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}