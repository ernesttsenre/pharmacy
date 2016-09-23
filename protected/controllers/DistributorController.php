<?php

class DistributorController extends Controller
{
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $file = new File;
        $formData = Yii::app()->request->getParam('File', null);
        if ($formData) {
            $file->attributes = $formData;
            $file->document = CUploadedFile::getInstance($file, 'document');
            $file->path = sprintf('%s/upload/%s_%s.txt', Yii::getPathOfAlias('webroot'), $model->id, time());

            $isSuccess = false;
            if ($file->save()) {
                $file->document->saveAs($file->path);
                $isSuccess = $file->convert();
            }

            if ($isSuccess) {
                $this->redirect(Yii::app()->createUrl('/file/view', ['id' => $file->id]));
            } else {
                // todo: create error message
            }
        }

        $dataProvider = $model->getExistsProvider();

        $this->render('view', [
            'model' => $model,
            'file' => $file,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return Distributor
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = Distributor::model()->findByPk($id);

        if (!$model) {
            throw new CHttpException(404, Yii::t('error', 'not_found', ['object' => 'Distributor']));
        }

        return $model;
    }
}