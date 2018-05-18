<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\View;
use app\models\RegistrationForm;
use app\models\MyUser;
use yii\data\Pagination;
class SiteController extends Controller
{   
    //public $layout="newlayout";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','about','contact'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                                            [
                           'allow' => true,
                           'actions' => ['about'],
                           'roles' => ['?'],
                        ],
                        [
                           'allow' => true,
                           'actions' => ['contact', 'about'],
                           'roles' => ['@'],
                        ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
           $model->scenario = ContactForm::SCENARIO_EMAIL_FROM_USER;
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
    \Yii::$app->view->on(View::EVENT_BEGIN_BODY, function () {
      echo date('m.d.Y H:i:s');
   });
        return $this->render('about');
    }

    public function actionSpeak($message = "default message") { 
         return $this->render("speak",['message' => $message]); 
      } 

     public function actionShowContactModel() { 
       $mContactForm = new \app\models\ContactForm(); 
       $mContactForm->name = "contactForm"; 
       $mContactForm->email = "user@gmail.com"; 
       $mContactForm->subject = "subject"; 
       $mContactForm->body = "body"; 
        return \yii\helpers\Json::encode($mContactForm);
    } 
    
  // Widget
    public function actionTestWidget() { 
        return $this->render('testwidget'); 
}

    public function actionRegistration() { 
       $model = new RegistrationForm(); 
       if (Yii::$app->request->isAjax && $model->load(Yii::$app->request>post())) { 
          Yii::$app->response->format = Response::FORMAT_JSON; 
          return ActiveForm::validate($model); 
       } 
       return $this->render('registration', ['model' => $model]); 
    }

    public function actionOpenAndCloseSession() {
       $session = Yii::$app->session;
       // open a session
       $session->open();
       // check if a session is already opened
       if ($session->isActive) echo "session is active";
       // close a session
       $session->close();
       // destroys all data registered to a session
       $session->destroy();
    }

    public function actionAccessSession() {

   $session = Yii::$app->session;
    
   // set a session variable
   $session->set('language', 'ru-RU');
    
   // get a session variable
   $language = $session->get('language');
   var_dump($language);
          
   // remove a session variable
   $session->remove('language');
          
   // check if a session variable exists
   if (!$session->has('language')) echo "language is not set";
          
   $session['captcha'] = [
      'value' => 'aSBS23',
      'lifetime' => 7200,
   ];
   var_dump($session['captcha']);
}

    public function actionReadCookies() { 

       $cookies = Yii::$app->request->cookies; 
       $language = $cookies->getValue('language', 'ru'); 
       if (($cookie = $cookies->get('language')) !== null) { 
          $language = $cookie->value; 
       } 
       if (isset($cookies['language'])) { 
          $language = $cookies['language']->value; 
       } 
       if ($cookies->has('language')) echo "Current language: $language"; 
    }

    public function actionSendCookies() { 

       $cookies = Yii::$app->response->cookies; 
       $cookies->add(new \yii\web\Cookie([ 
          'name' => 'language', 
          'value' => 'ru-RU', 
       ])); 
       $cookies->add(new \yii\web\Cookie([
          'name' => 'username', 
          'value' => 'John', 
       ])); 
       $cookies->add(new \yii\web\Cookie([ 
          'name' => 'country', 
          'value' => 'USA', 
       ])); 
} 

        public function actionPagination() {

           $query = MyUser::find();
           $count = $query->count();
           $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 5]);
           $models = $query->offset($pagination->offset)
              ->limit($pagination->limit)
              ->all();
           return $this->render('pagination', [
              'models' => $models,
              'pagination' => $pagination,
           ]);
        }

        public function actionTestEvent() {
           $model = new MyUser();
           $model->name = "John";
           $model->email = "john@gmail.com";
           if($model->save()) {
              $model->trigger(MyUser::EVENT_NEW_USER);
           }
}

        public function actionTestDb(){

           $users = Yii::$app->db->createCommand('SELECT * FROM user LIMIT 5')
              ->queryAll();
        //   var_dump($users);

           $user = Yii::$app->db->createCommand('SELECT * FROM user WHERE id=1')
              ->queryOne();
           var_dump($user);

           $userName = Yii::$app->db->createCommand('SELECT name FROM user')
              ->queryColumn();
          // var_dump($userName);

           $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM user')
              ->queryScalar();
          // var_dump($count);
        }

        public function actionA($i) {
           $firstUser = Yii::$app->db->createCommand('SELECT * FROM user WHERE id = :id')
              ->bindValue(':id', $i)
              ->queryOne();
            return json_encode($firstUser);
        }

        public function actionAddUser() {
           // insert a new row of data
           $user = new MyUser();
           $user->name = 'Mehdi';
           $user->email = 'mehdi@gmail.com';
           $user->save();
           
           return ('User added successfully');           
        }

        public function actionMehdi(){
           /* $users = Yii::$app->db->createCommand('Select * from user where name= :name')
            ->bindValue(':name' , 'mehdi');
            return json_encode($users);*/

            $firstUser = Yii::$app->db->createCommand('SELECT * FROM user where name= :name')
            ->bindValue(':name', 'mehdi')
            ->queryAll();
            return json_encode($firstUser);
        }

public function actionTranslation() {
   echo \Yii::t('app', 'This is a string to translate!');
}

public function actionUserview()
{
    $model = new \app\models\MyUser();

    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            $model->save();
            return;
        }
    }

    return $this->render('userview', [
        'model' => $model,
    ]);
}


}
