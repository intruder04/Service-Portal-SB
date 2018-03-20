<?php
use yii\grid\GridView;
?>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'table table-bordered table-hover'
    ],
    'columns' => [
        [
            'attribute' => 'sb_id',
            'contentOptions' => ['style' => 'width:10%;  min-width:30px;'],
        ],
        [
            'attribute' => 'status',
            'value' => 'statuses.status',
            'contentOptions' => ['style' => 'width:10%;  min-width:50px;'],
        ],
        [
            'attribute' => 'descr',
            'contentOptions' => ['style' => 'width:40%;  min-width:200px;'],
        ],
        [
            'attribute' => 'workgroup_id',
            'value' => 'workgroups.wg_name',
            'contentOptions' => ['style' => 'width:10%;'],
        ],
        [
            'attribute' => 'assignee',
            'value' => 'user.displayname',
            'contentOptions' => ['style' => 'width:20%;'],
        ],
        'date_created:datetime',
        'date_deadline:datetime',
    ],
    'rowOptions' =>function($model) {
//Подсветка контрольного срока. Если 30 минут до КС - желтый. Если текущее время старше КС - красный
        $class = ((time() > $model['date_deadline'] - 1800) && ($model['status'] != 7) && (time() < $model['date_deadline'])) ? 'warning' : (time() > $model['date_deadline'] && $model['status'] != 7 ? 'danger':'');
        return [
            'id' => $model['id'],
            'style' => "cursor: pointer",
            'class'=>$class,
            'onclick' => 'location.href="/reqexpl/update?id="+(this.id);'
        ];
    },
]);

?>
