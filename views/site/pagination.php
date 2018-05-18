<?php
   use yii\widgets\LinkPager;
?>
<?php foreach ($models as $model): ?>
   <?= $model->id; ?>
   <?= $model->name; ?>
   <?= $model->email; ?>
   <br/>
<?php endforeach; ?>
<?php
   echo LinkPager::widget([
      'pagination' => $pagination,
   ]);
?>

<?php
   use yii\widgets\DetailView;
   echo DetailView::widget([
      'model' => $model,
      'attributes' => [
         'id',
         //formatted as html
         'name:html',
         [
            'label' => 'e-mail',
            'value' => $model->email,
         ],
      ],
   ]);
?>