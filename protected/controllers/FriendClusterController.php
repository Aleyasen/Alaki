<?php

class FriendClusterController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'FriendCluster'),
		));
	}

	public function actionCreate() {
		$model = new FriendCluster;


		if (isset($_POST['FriendCluster'])) {
			$model->setAttributes($_POST['FriendCluster']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'FriendCluster');


		if (isset($_POST['FriendCluster'])) {
			$model->setAttributes($_POST['FriendCluster']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'FriendCluster')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('FriendCluster');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new FriendCluster('search');
		$model->unsetAttributes();

		if (isset($_GET['FriendCluster']))
			$model->setAttributes($_GET['FriendCluster']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}