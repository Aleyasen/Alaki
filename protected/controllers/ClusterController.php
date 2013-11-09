<?php

class ClusterController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Cluster'),
		));
	}

	public function actionCreate() {
		$model = new Cluster;


		if (isset($_POST['Cluster'])) {
			$model->setAttributes($_POST['Cluster']);
			$relatedData = array(
				'friends' => $_POST['Cluster']['friends'] === '' ? null : $_POST['Cluster']['friends'],
				'corFriends' => $_POST['Cluster']['corFriends'] === '' ? null : $_POST['Cluster']['corFriends'],
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
		$model = $this->loadModel($id, 'Cluster');


		if (isset($_POST['Cluster'])) {
			$model->setAttributes($_POST['Cluster']);
			$relatedData = array(
				'friends' => $_POST['Cluster']['friends'] === '' ? null : $_POST['Cluster']['friends'],
				'corFriends' => $_POST['Cluster']['corFriends'] === '' ? null : $_POST['Cluster']['corFriends'],
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
			$this->loadModel($id, 'Cluster')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Cluster');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Cluster('search');
		$model->unsetAttributes();

		if (isset($_GET['Cluster']))
			$model->setAttributes($_GET['Cluster']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}