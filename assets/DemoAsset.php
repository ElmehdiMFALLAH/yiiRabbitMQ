<?php
   namespace app\assets;
   use yii\web\AssetBundle;
   class DemoAsset extends AssetBundle {
      public $basePath = '@webroot';
      public $baseUrl = '@web';
      public $js = ['js/demo.js'];
   }
?>