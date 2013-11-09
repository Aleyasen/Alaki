<?php

class FriendController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Friend'),
		));
	}

	public function actionCreate() {
		$model = new Friend;


		if (isset($_POST['Friend'])) {
			$model->setAttributes($_POST['Friend']);
			$relatedData = array(
				'clusters' => $_POST['Friend']['clusters'] === '' ? null : $_POST['Friend']['clusters'],
				'corClusters' => $_POST['Friend']['corClusters'] === '' ? null : $_POST['Friend']['corClusters'],
				);

			if ($model->saveWithRelated($relatedData)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Friend');


		if (isset($_POST['Friend'])) {
			$model->setAttributes($_POST['Friend']);
			$relatedData = array(
				'clusters' => $_POST['Friend']['clusters'] === '' ? null : $_POST['Friend']['clusters'],
				'corClusters' => $_POST['Friend']['corClusters'] === '' ? null : $_POST['Friend']['corClusters'],
				);

			if ($model->saveWithRelated($relatedData)) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Friend')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Friend');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Friend('search');
		$model->unsetAttributes();

		if (isset($_GET['Friend']))
			$model->setAttributes($_GET['Friend']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}