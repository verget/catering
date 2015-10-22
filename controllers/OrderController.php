<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\Menu;
use app\models\Item;
use app\models\OrderItem;
use app\models\OrderLocation;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                    'allow' => false,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    'roles' => ['?'],
                    ],
                    [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->joinWith(['orderLocationName']),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $order_items = OrderItem::find(['order_id' => $id])->joinWith('item')->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'locations' => $this->getAllLocations(),
            'order_items' => $order_items 
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        
        $model->load(Yii::$app->request->post());
        $model->order_user_id = Yii::$app->user->identity->id;

        if ($model->save()) {
            $request = Yii::$app->request;
            if (isset($request->post()['Order']['order_items'])){
                $items = $request->post()['Order']['order_items'];
                foreach ($items as $key => $val){ 
                    $order_item = new OrderItem();
                    $order_item->item_id = $val;
                    $order_item->order_id = $model->order_id;
                    $order_item->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'locations' => $this->getAllLocations(),
                'all_menu' => $this->getAllMenu(),
                'addons' => Item::find()->asArray()->where(['item_type' =>  Item::ADDON_TYPE])->all()
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $order_items = OrderItem::find(['order_id' => $id])->joinWith('item')->all();
        if ($model->load(Yii::$app->request->post())){
            $request = Yii::$app->request;
            var_dump($request->post()['Order']['order_items']);
            die();
            OrderItem::deleteAll(['order_id' => $id]);
            if (isset($request->post()['Order']['order_items'])){
                $items = $request->post()['Order']['order_items'];
                foreach ($items as $key => $val){
                    $double = OrderItem::find()->where(['item_id' => $key, 'order_id' => $id])->count();
                    if(!$double){
                        $order_item = new OrderItem();
                        $order_item->item_id = $key;
                        $order_item->count = $val;
                        $order_item->order_id = $id;
                        $order_item->save();
                    }
                }
            }
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'locations' => $this->getAllLocations(),
                'all_menu' => $this->getAllMenu(),
                'addons' => Item::find()->asArray()->where(['item_type' =>  Item::ADDON_TYPE])->all(),
                'order_items' => $this->getOrderItems($id)
                            
            ]);
        }
    }
    protected function getOrderItems($id){
        $order_items = OrderItem::find(['order_id' => $id])->all();
        $items = ArrayHelper::map($order_items, 'item_id', 'count');
    
        return $items;
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    public static function getAllLocations(){
        $locations = OrderLocation::find()->asArray()->all();
        $location_array = [];
        foreach ($locations as $key=>$value)
            $location_array[$value['location_id']] = $value['location_name'];
        return $location_array;
    }
    
    public static function getLocationName($data){
        return OrderLocation::findOne($data);
    }
    
    public static function getAllMenu(){
        $items =  Menu::find()->asArray()->all();
        $all = [];
        
        foreach ($items as $key => $value){
            $add = "";
            
            if($value['menu_type'] == 'doeuvres')
                $add = " $".$value['menu_price']."/dozen";
            elseif($value['menu_type'] == 'reseption')
            $add = " $".$value['menu_price']."/person";
            
            $all[$value['menu_type']][$value['menu_id']] = $value['menu_name'].$add ;
        }
        return $all;
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
