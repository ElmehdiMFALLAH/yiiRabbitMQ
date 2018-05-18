<?php
   namespace app\modules\hello\controllers;
   use yii\web\Controller;
   use Yii;

   class CustomController extends Controller {


      public function actionGreet() {
         return $this->render('greet');
      }

      public function actionAbout(){
      	return $this->render('about');
      }

      public function actionUser(){

	    $firstUser = Yii::$app->db->createCommand('SELECT * FROM user where name= :name')
	    ->bindValue(':name', 'mehdi')
	    ->queryAll();
	    return json_encode($firstUser);
}

   }
?>