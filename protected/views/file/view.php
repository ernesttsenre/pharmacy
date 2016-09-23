<?php
/**
 * @var FileController $this
 * @var File $model
 * @var CActiveDataProvider $dataProvider
 */
?>

<?php
$this->menu = array(
    ['label' => Yii::t('app', 'file_page.link.complete'), 'url' => Yii::app()->createUrl('/file/complete', ['id' => $model->id])],
    ['label' => Yii::t('app', 'file_page.link.compare_pharmacy'), 'url' => Yii::app()->createUrl('/file/comparePharmacy', ['id' => $model->id])],
    ['label' => Yii::t('app', 'file_page.link.compare_product'), 'url' => Yii::app()->createUrl('/file/compareProduct', ['id' => $model->id])],
);
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        [
            'name' => 'product',
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'pharmacy',
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'count',
            'value' => function ($data) {
                /** @var FileExist $data */
                return number_format($data->count, 2, ',', ' ');
            },
            'htmlOptions' => [
                'class' => 'text-right'
            ],
            'headerHtmlOptions' => [
                'class' => 'text-right'
            ],
        ],
        [
            'name' => 'created',
            'value' => function ($data) {
                /** @var FileExist $data */
                return Yii::app()->dateFormatter->format('d MMMM y', strtotime($data->created));
            },
            'htmlOptions' => [
                'class' => 'text-right'
            ],
            'headerHtmlOptions' => [
                'class' => 'text-right'
            ],
        ],
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>