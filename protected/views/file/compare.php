<?php
/**
 * @var FileController $this
 * @var array $current
 * @var array $available
 */
?>

<div class="form">

    <?php echo CHtml::beginForm() ?>

    <?php foreach ($current as $item): ?>
        <div class="row">
            <?php echo CHtml::label($item, '') ?>
            <?php echo CHtml::dropDownList(sprintf('Compare[%s]', $item), null, $available, ['empty' => 'Выберите из списка']) ?>
        </div>
    <?php endforeach ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('app', 'project.save_button.title')); ?>
    </div>

    <?php echo CHtml::endForm() ?>

</div>
