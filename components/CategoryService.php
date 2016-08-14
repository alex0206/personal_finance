<?php

namespace app\components;


use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class CategoryService extends ServiceBase
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCategories()
    {
        /** @var ActiveRecord $model */
        $model = $this->getModelClassName();

        return $model::find()->orderBy('name')->all();
    }

    /**
     * Getting category map
     * @return array
     */
    public function getCategoryMap()
    {
        $categories = $this->getCategories();

        return ArrayHelper::map($categories, 'category_id', 'name');
    }
}