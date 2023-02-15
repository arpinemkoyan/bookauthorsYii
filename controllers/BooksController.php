<?php

namespace app\controllers;

use app\models\Authors;
use app\models\Books;
use app\models\BooksAuthors;
use app\models\BooksSearch;
use Yii;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Books models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Books model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Books();
        $authors = Authors::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                //fill BooksAuthors
                $authorsData = $this->request->post()['Books']['authors'];
                $bulkInsertArray = [];
                foreach ($authorsData as $authorId) {
                    $bulkInsertArray[] = [
                        'book_id' => $model->id,
                        'author_id' => $authorId,
                    ];
                }

                $columnNames = ['book_id', 'author_id'];
                Yii::$app->db->createCommand()
                    ->batchInsert(
                        'books_authors', $columnNames, $bulkInsertArray
                    )
                    ->execute();


                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'authors' => $authors
        ]);
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->load($this->request->post());

            BooksAuthors::deleteAll(['book_id' => $model->id]);
            //fill BooksAuthors
            $authorsData = $this->request->post()['Books']['authors'];
            $bulkInsertArray = [];
            foreach ($authorsData as $authorId) {
                $bulkInsertArray[] = [
                    'book_id' => $model->id,
                    'author_id' => $authorId,
                ];
            }

            $columnNames = ['book_id', 'author_id'];
            Yii::$app->db->createCommand()
                ->batchInsert(
                    'books_authors', $columnNames, $bulkInsertArray
                )
                ->execute();

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $authors = Authors::find()->all();

        return $this->render('update', [
            'model' => $model,
            'authors' => $authors
        ]);
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}