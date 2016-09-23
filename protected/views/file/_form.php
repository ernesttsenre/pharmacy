<?php
/**
 * @var FileController $this
 * @var FileExist $model
 * @var CActiveForm $form
 */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'file-exist-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">
        <?php echo Yii::t('app', 'project.required_fields', ['{marker}' => '<span class="required">*</span>']) ?>
    </p>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'file_id'); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'pharmacy'); ?>
        <?php echo $form->textField($model,'pharmacy',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'pharmacy'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'product'); ?>
        <?php echo $form->textField($model,'product',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'product'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'count'); ?>
        <?php echo $form->textField($model,'count',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'count'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('app', 'project.save_button.title')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>