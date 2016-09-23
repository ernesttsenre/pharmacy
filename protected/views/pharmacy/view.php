<?php
/**
 * @var DistributorController $this
 * @var Pharmacy $model
 * @var CArrayDataProvider $dataProvider
 * @var array $totals
 */
?>

<h1>
    <?php echo Yii::t('app', 'pharmacy_page.view.title', ['{pharmacy}' => $model->title]) ?>
</h1>

<br>
<hr>
<h3>
    <?php echo Yii::t('app', 'pharmacy_page.view.total') ?>
</h3>

<table>
    <thead>
    <tr>
        <th>Всего</th>
        <?php foreach ($totals['distributors'] as $distributorTitle => $distributorCount): ?>
            <th><?php echo $distributorTitle ?></th>
        <?php endforeach ?>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo number_format($totals['total'], 2, ',', ' ') ?></td>
        <?php foreach ($totals['distributors'] as $distributorTitle => $distributorCount): ?>
            <td><?php echo number_format($distributorCount, 2, ',', ' ') ?></td>
        <?php endforeach ?>
    </tr>
    </tbody>
</table>

<br>
<hr>
<h3>
    <?php echo Yii::t('app', 'pharmacy_page.view.header') ?>
</h3>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        [
            'name' => 'id',
            'header' => Yii::t('app', 'pharmacy_page.table.id'),
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'product',
            'header' => Yii::t('app', 'pharmacy_page.table.product'),
            'headerHtmlOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'name' => 'count',
            'header' => Yii::t('app', 'pharmacy_page.table.count'),
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
