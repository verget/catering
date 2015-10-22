<?php

namespace app\controllers;

use Yii;
use app\models\Menu;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\MenuItem;
use app\models\OrderItem;
use app\models\Item;
use app\models\Order;
use yii\helpers\ArrayHelper;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find()->joinWith('menuItems'),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->menu_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $dataProvider = new ActiveDataProvider([
        		'query' => Item::find()->joinWith('menuItems')->where(['menu_id' => $model->menu_id]),
                'pagination' => ['pageSize' => 10,],
        ]);
        
        $all_items = Item::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->menu_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
        		'dataProvider' => $dataProvider,
                'all_items' => $all_items,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionAddItems(){
        $request = Yii::$app->request;
        $items = json_decode($request->post('items'));

        foreach ($items as $item){
            $model = new MenuItem();
            $model->item_id = $item;
            $model->menu_id = $request->post('menu');
            $model->save();
        }
        return true;
    }
    public function actionDeleteItem(){
        $request = Yii::$app->request;
        $item_id = $request->post('item');
        $menu_id = $request->post('menu');
        $item = MenuItem::findOne([
                        'item_id'=> $item_id,
                        'menu_id'=> $menu_id,
        ]);
        $item->delete();
        return true;
    }
    
    public function actionGetMenu(){
        $request = Yii::$app->request;
        $id = $request->post('id');
        $order_id = $request->post('order_id');
        $menu = $this->findModel($id);
        $order = $order_items = "";
        if ($order_id){
            $order = Order::find($order_id)->one();
            $order_items = OrderItem::find(['order_id' => $order_id])->all();
            $order_items = ArrayHelper::map($order_items, 'item_id', 'count');
        }
        
        $items = ArrayHelper::map($menu->menuItems, 'item_id', 'item_name', 'item_tarif');
        
        return json_encode (['desc' => $menu->menu_desc, 'limit' => $menu->menu_limit, 'items' => $items, 'order_items' => $order_items]);
    }
    



    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
