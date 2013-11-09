<?php

class ClusteringController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Clustering'),
		));
	}

	public function actionCreate() {
		$model = new Clustering;


		if (isset($_POST['Clustering'])) {
			$model->setAttributes($_POST['Clustering']);

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
		$model = $this->loadModel($id, 'Clustering');


		if (isset($_POST['Clustering'])) {
			$model->setAttributes($_POST['Clustering']);

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
			$this->loadModel($id, 'Clustering')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Clustering');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Clustering('search');
		$model->unsetAttributes();

		if (isset($_GET['Clustering']))
			$model->setAttributes($_GET['Clustering']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}