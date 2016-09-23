<?php
/**
 * @var FileController $this
 * @var CActiveDataProvider $dataProvider
 */
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        [
            'name' => 'id',
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'distributor.title',
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'created',
            'value' => function ($data) {
                /** @var File $data */
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
            'template' => '{view}',
            'viewButtonUrl' => function ($data) {
                /** @var File $data */
                return Yii::app()->createUrl('/file/view', ['id' => $data->id]);
            }
        ),
    ),
));
?>