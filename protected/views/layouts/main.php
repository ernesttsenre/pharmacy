<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print">

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection">
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

    <title>
        <?php echo Yii::t('app', 'project.title') ?>
    </title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo">
            <?php echo Yii::t('app', 'project.title') ?>
        </div>
    </div>

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => Yii::t('app', 'main_page.title'), 'url' => array('/site/index')),
                array('label' => Yii::t('app', 'pharmacy_page.title'), 'url' => array('/pharmacy/index')),
                array('label' => Yii::t('app', 'file_page.title'), 'url' => array('/file/index')),
            ),
        )); ?>
    </div>
    <?php if (isset($this->breadcrumbs)): ?>
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
        ));
        ?>
    <?php endif ?>

    <?php if ($this->menu): ?>
        <div class="span-19">
            <div id="content">
                <?php echo $content; ?>
            </div>
        </div>
        <div class="span-5 last">
            <div id="sidebar">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => Yii::t('app', 'project.menu'),
                ));
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $this->menu,
                    'htmlOptions' => array('class' => 'operations'),
                ));
                $this->endWidget();
                ?>
            </div>
        </div>
    <?php else: ?>
        <div id="content">
            <?php echo $content; ?>
        </div>
    <?php endif ?>

    <div class="clear"></div>

</div>

</body>
</html>
