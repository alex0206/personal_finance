<?php

namespace app\controllers;

use app\models\DetailReportSearch;
use app\models\TotalReportSearch;
use Yii;
use yii\filters\AccessControl;

class ReportController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class'  => AccessControl::className(),
                'rules'  => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionDetail($month, $year)
    {
        $searchModel = new DetailReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('detail', compact('month', 'year', 'dataProvider'));
    }

    public function actionIndex()
    {
        $searchModel = new TotalReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

}
