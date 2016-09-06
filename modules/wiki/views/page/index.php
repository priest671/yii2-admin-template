<?php

use app\helpers\Icon;
use app\widgets\Box;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $rootPages modules\wiki\models\Wiki[] */

$this->title = Yii::t('app', 'Wiki');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'label' => Yii::t('app', 'Page list'),
    'actions' => [
        [
            'value' => Html::a(Icon::PLUS . Yii::t('app', 'Create'), ['page/create']),
        ],
    ],
]) ?>
<ul class="list-unstyled pages">
    <?php foreach ($rootPages as $wiki): ?>
    <li class="wiki-page">
        <?= Html::a(Icon::icon($wiki->getChildren()->count() ? 'fa fa-book' : 'fa fa-file-text') . e($wiki->title), ['page/view', 'id' => $wiki->id]) ?>
    </li>
    <?php endforeach ?>
</ul>
<?php Box::end() ?>