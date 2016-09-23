<?php
/**
 * @var DistributorController $this
 * @var Distributor $model
 * @var File $file
 * @var CArrayDataProvider $dataProvider
 */
?>

<h1>
    <?php echo $model->title ?>
</h1>

<br>
<hr>
<h3>
    <?php echo Yii::t('app', 'distribution_page.upload') ?>
</h3>

<?php echo CHtml::form('', 'post', array('enctype' => 'multipart/form-data')); ?>
<?php echo CHtml::activeFileField($file, 'document'); ?>
<?php echo CHtml::activeHiddenField($file, 'distributor_id', ['value' => $model->id]); ?>
<?php echo CHtml::submitButton(); ?>
<?php echo CHtml::endForm(); ?>

<br>
<hr>
<h3>
    <?php echo Yii::t('app', 'distribution_page.header') ?>
</h3>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        [
            'name' => 'pharmacy',
            'header' => Yii::t('app', 'distribution_page.table.id'),
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link($data['pharmacy'], Yii::app()->createUrl('/pharmacy/view', ['id' => $data['id']]));
            },
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'count',
            'header' => Yii::t('app', 'distribution_page.table.count'),
            'value' => function ($data) {
                return number_format($data['count'], 2, ',', ' ');
            },
            'htmlOptions' => [
                'class' => 'text-right'
            ],
            'headerHtmlOptions' => [
                'class' => 'text-right'
            ],
        ],
    ),
));
?>
