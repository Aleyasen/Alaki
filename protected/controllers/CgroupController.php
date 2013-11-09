<?php

class CgroupController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Cgroup'),
        ));
    }

    public function actionAdd2($id) {
        $model = new Cgroup;
        $model->user = $id;
        $garr = Cgroup::model()->findAll('user=:user', array(':user' => $id));
        $glist = new CArrayDataProvider('Cgroup');
        $glist->setData($garr);
        echo count($glist);
        if (isset($_POST['Cgroup'])) {
            $model->setAttributes($_POST['Cgroup']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('add2', 'id' => $id));
            }
        }

        $this->render('add2', array('model' => $model, 'glist' => $glist));
    }

    public function actionCreate() { //do not edit this one!
        $model = new Cgroup;


        if (isset($_POST['Cgroup'])) {
            $model->setAttributes($_POST['Cgroup']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Cgroup');


        if (isset($_POST['Cgroup'])) {
            $model->setAttributes($_POST['Cgroup']);

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
            $this->loadModel($id, 'Cgroup')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Cgroup');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Cgroup('search');
        $model->unsetAttributes();

        if (isset($_GET['Cgroup']))
            $model->setAttributes($_GET['Cgroup']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}