<?php
/**
 * @var SiteController $this
 * @var Distributor $model
 */
?>

<h1>
    <?php echo Yii::t('app', 'main_page.header') ?>
</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
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
                /** @var Distributor $data */
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
                /** @var Distributor $data */
                return Yii::app()->createUrl('/distributor/view', ['id' => $data->id]);
            }
        ),
    ),
));
?>