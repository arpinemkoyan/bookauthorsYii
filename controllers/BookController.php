<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;
use app\models\BookSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Book();
        $authors = Author::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                //fill BookAuthor
                $authorsData = $this->request->post()['Book']['author'];
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
            'author' => $authors
        ]);
    }

    /**
     * Updates an existing Book model.
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

            BookAuthor::deleteAll(['book_id' => $model->id]);
            //fill BookAuthor
            $authorsData = $this->request->post()['Book']['author'];
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

        $authors = Author::find()->all();

        return $this->render('update', [
            'model' => $model,
            'author' => $authors
        ]);
    }

    /**
     * Deletes an existing Book model.
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
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
