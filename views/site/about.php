<?php
   /* @var $this yii\web\View */
   use yii\helpers\Html;
   use yii\helpers\HtmlPurifier;
      use kartik\datetime\DateTimePicker;

   $this->title = 'About';
   $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
   <h1><?= Html::encode($this->title) ?></h1>
   <p>
      This is the About page. You may modify the following file to customize its content:
   </p>
   <p>
      <?= Html::encode("<script>alert('alert!');</script><h1>ENCODE EXAMPLE</h1>>") ?>
   </p>
   <p>
      <?= HtmlPurifier::process("<script>alert('alert!');</script><h1> HtmlPurifier EXAMPLE</h1>") ?>
   </p>

      <?= $this->render("_part1") ?>
   	  <?= $this->render("_part2") ?>

        <?php
      echo DateTimePicker::widget([
         'name' => 'dp_1',
         'type' => DateTimePicker::TYPE_INPUT,
         'value' => '23-Feb-1982 10:10',
         'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-M-yyyy hh:ii'
         ]
      ]);
   ?>

</div>