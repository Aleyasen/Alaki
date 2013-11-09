<?php

Yii::import('application.models._base.BaseCgroup');

class Cgroup extends BaseCgroup
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}