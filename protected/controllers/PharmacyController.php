<?php

class PharmacyController extends Controller
{
    public function actionIndex()
    {
        $model = new Pharmacy;

        $this->render('index', [
            'dataProvider' => $model->search(),
        ]);
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $dataProvider = $model->getExistsProvider();
        $totals = Pharmacy::getTotals($dataProvider);

        $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'totals' => $totals,
        ]);
    }

    /**
     * @param integer $id
     * @return Pharmacy
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = Pharmacy::model()->findByPk($id);

        if (!$model) {
            throw new CHttpException(404, Yii::t('error', 'not_found', ['object' => 'Pharmacy']));
        }

        return $model;
    }
}