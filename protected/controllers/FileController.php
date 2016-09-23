<?php

class FileController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('File', [
            'criteria' => array(
                'condition' => 'status = :status',
                'params' => ['status' => File::STATUS_PROCESS]
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ]);

        $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionComplete($id)
    {
        /** @var File $model */
        $model = $this->loadModel($id);
        $model->complete();

        $this->redirect(Yii::app()->createUrl('/distributor/view', ['id' => $model->distributor_id]));
    }

    public function actionComparePharmacy($id)
    {
        /** @var Pharmacy $model */
        $model = $this->loadModel($id);
        $currentPharmacies = $model->getCurrentTitles('pharmacy');
        $availablePharmacies = $model->getAvailableTitles('pharmacy');

        $formData = Yii::app()->request->getParam('Compare', null);
        if ($formData) {
            File::comparePharmacies($formData, 'pharmacy');

            $this->redirect(Yii::app()->createUrl('/file/view', ['id' => $model->id]));
        }

        $this->render('compare', [
            'current' => $currentPharmacies,
            'available' => $availablePharmacies,
        ]);
    }

    public function actionCompareProduct($id)
    {
        /** @var Pharmacy $model */
        $model = $this->loadModel($id);
        $currentPharmacies = $model->getCurrentTitles('product');
        $availablePharmacies = $model->getAvailableTitles('product');

        $formData = Yii::app()->request->getParam('Compare', null);
        if ($formData) {
            File::comparePharmacies($formData, 'product');

            $this->redirect(Yii::app()->createUrl('/file/view', ['id' => $model->id]));
        }

        $this->render('compare', [
            'current' => $currentPharmacies,
            'available' => $availablePharmacies,
        ]);
    }

    public function actionView($id)
    {
        /** @var File $model */
        $model = $this->loadModel($id);

        $dataProvider = new CActiveDataProvider('FileExist', [
            'criteria' => array(
                'condition' => 'file_id = :fileId',
                'params' => ['fileId' => $id]
            ),
            'pagination' => array(
                'pageSize' => 200,
            ),
        ]);

        $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        /** @var FileExist $model */
        $model = $this->loadModel($id, 'FileExist');

        $formData = Yii::app()->request->getParam('FileExist', null);
        if ($formData) {
            $model->attributes = $formData;
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->file_id));
            }
        }

        $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        /** @var FileExist $model */
        $model = $this->loadModel($id, 'FileExist');
        $fileId = $model->file_id;

        $model->delete();

        $this->redirect(array('view', 'id' => $fileId));
    }

    /**
     * @param integer $id
     * @param string $class
     * @return File
     * @throws CHttpException
     */
    protected function loadModel($id, $class = 'File')
    {
        $model = $class::model()->findByPk($id);

        if (!$model) {
            throw new CHttpException(404, Yii::t('error', 'not_found', ['object' => $class]));
        }

        return $model;
    }
}