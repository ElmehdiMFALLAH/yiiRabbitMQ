<?php 
   namespace app\controllers; 
   use yii\web\Controller; 

   class MovieController extends Controller { 

      //public $defaultAction="google";  To make actionGoogle the default action
  
      public function actions() {
         return [
            'greeting' => 'app\components\GreetingAction',
            'hello' => 'app\components\HelloAction',
         ];
      }

      public function actionIndex() { 
         $movieTitle = "Den of thieves"; 
         return $this->render("movies",[ 
            'movieTitle' => $movieTitle 
         ]); 
      }

      public function actionGoogle() {
      return $this->redirect('http://google.com');
}  


   } 
?>