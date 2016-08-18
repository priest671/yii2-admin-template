<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $form yii\bootstrap\ActiveForm */
/** @var $model app\forms\user\Register */

$this->title = t('User register');
$fieldOptions = function ($icon) {
    return [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-$icon form-control-feedback'></span>"
    ];
};
?>

<div class="register-box">
    <div class="register-logo">
        <a href="<?= Url::home(true) ?>"><b><?= Yii::$app->name ?></b></a>
    </div> <!-- /.register-logo -->
    
    <div class="register-box-body">
        <p class="register-box-msg"><?= t('Register a new account') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'register-form', 'enableClientValidation' => false]); ?>

        <?= $form
                ->field($model, 'name', $fieldOptions('user'))
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('name')]) ?>

        <?= $form
                ->field($model, 'email', $fieldOptions('envelope'))
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
        
        <?= $form
            ->field($model, 'password', $fieldOptions('lock'))
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form
            ->field($model, 'password_repeat', $fieldOptions('lock'))
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]) ?>
        
        <div class="row">
            <div class="col-xs-12">
                <?= Html::submitButton(t('Register'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'register-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>
        
        <div class="account-links">
            <a href="<?= Url::to(['user/login']) ?>"><?= t('I already have an account') ?></a><br>
        </div>

    </div>
    <!-- /.register-box-body -->
    
</div><!-- /.register-box -->