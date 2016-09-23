<?php
/**
 * @var SiteController $this
 * @var CActiveDataProvider $dataProvider
 */
?>

<h1>
    <?php echo Yii::t('app', 'pharmacy_page.header') ?>
</h1>

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
            'name' => 'title',
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'created',
            'value' => function ($data) {
                /** @var Pharmacy $data */
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
        ),
    ),
));
?>