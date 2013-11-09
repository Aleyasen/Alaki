<?php

Yii::import('application.models._base.BaseFeed');

class Feed extends BaseFeed
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}