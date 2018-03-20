<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * RequestsSearch represents the model behind the search form about `app\models\Requests`.
 */
class RequestsSearch extends Requests
{
    public $companyname;
    public $workgroups;

    public function getAction() {
        return Yii::$app->controller->action->id;
    }

    public function getPrevPage() {
        return isset($_GET['f']) ? $_GET['f'] : '';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'date_updated', 'workgroup_id', 'company_id','assignee'], 'integer'],
            [['sb_id', 'descr', 'full_descr', 'solution', 'workgroup_id', 'assignee', 'workgroups','sberwg','closure_code','bank_contact','bank_contact_phone','date_created','date_done','date_deadline','ride_start_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function setSidebarFilter($querypar) {
        if ($this->getAction() == 'index' && Requests::getRole() != 'admin') {
            $querypar->andFilterWhere([
                'requests.company_id' => Yii::$app->user->identity->company_id
            ]);
            # не показывать выполненные
            $querypar->andFilterWhere(['<', 'status', 7]);
        }

        if ($this->getAction() == 'my') {
            $querypar->andFilterWhere([
                'assignee' => Yii::$app->user->id
            ]);
            $querypar->andFilterWhere(['<', 'status', 7]);
        }

        if ($this->getAction() == 'mydone') {
            # Показывать выполненные и назначенные на залогиненного пользователя
            $querypar->andFilterWhere([
                'assignee' => Yii::$app->user->id,
                'status' => 7
            ]);
        }

        if ($this->getAction() == 'rejected') {
            $querypar->andFilterWhere([
                'requests.company_id' => Yii::$app->user->identity->company_id
            ]);
            # Только отозванные
            $querypar->andFilterWhere(['=', 'closure_code', 3]);
        }
}

//    метод для кнопок следующ\предыдущ
    public function NextOrPrev($currentId)
    {
        if ($this->getPrevPage() == 'index') {

            $records = Requests::find()->select(['requests.id'])->where(['=', 'company_id', Yii::$app->user->identity->company_id])->andwhere(['<', 'status', 7])->all();
        }
        if ($this->getPrevPage() == 'my') {

            $records = Requests::find()->select(['requests.id'])->where(['=', 'assignee', Yii::$app->user->id])->andwhere(['<', 'status', 7])->all();
        }
        if ($this->getPrevPage() == 'mydone') {

            $records = Requests::find()->select(['requests.id'])->where(['=', 'assignee', Yii::$app->user->id])->andwhere(['=', 'status', 7])->all();
        }
        if ($this->getPrevPage() == 'rejected') {

            $records = Requests::find()->select(['requests.id'])->where(['=', 'company_id', Yii::$app->user->identity->company_id])->andwhere(['=', 'closure_code', 3])->andwhere(['=', 'status', 8])->all();
        }

        if(!empty($records)) {
            foreach ($records as $i => $record) {
                if ($record->id == $currentId) {
                    $next = isset($records[$i - 1]->id) ? $records[$i - 1]->id : null;
//                debug($next);die;
                    $prev = isset($records[$i + 1]->id) ? $records[$i + 1]->id : null;
//                debug($prev);die;
                    break;
                } else {
                    $next = null;
                    $prev = null;
                }
            }
            return ['next' => $next, 'prev' => $prev];
        }
    }

    public function ButtonLogic($button_id, $model) {
        //Эксплуатация
        //Для кнопки "Взять в работу"
        if ($button_id == 1) {
            $user_id = Yii::$app->user->id;
            $status = 3;
            $assignee = $user_id;
            return ['status' => $status, 'assignee' => $assignee];
        }
        //Для кнопки "Выполнить"
        if ($button_id == 2) {
            $params = Yii::$app->request->post('Requests');
            $solution_param = $params['solution'];
            $closure_code_param = $params['closure_code'];
            $status = $model->status;
            $date_done = '';
            $solution = $model->solution;

            if ($solution_param == '' and $closure_code_param == '') {
                Yii::$app->session->setFlash('nosolution', "Заполните поля \"Решение\" и \"Код Закрытия\"!");
            }
            elseif ($solution_param == '') {
                Yii::$app->session->setFlash('nosolution', "Заполните поле \"Решение\"!");
            }
            elseif ($closure_code_param == '') {
                Yii::$app->session->setFlash('nosolution', "Заполните поле \"Код Закрытия\"!");
            }
            else {
                $status = 7;
                $date_done = time();
                $solution = $solution_param;
                $closure_code = $closure_code_param;
            }
            return ['status' => $status, 'date_done' => $date_done, 'solution' => $solution, 'closure_code' => $closure_code_param];
        }
    }

    public function search($params)
    {
        $query = Requests::find();
        //join with company table to make search
        $query->joinWith(['company']);
        $query->joinWith(['workgroups']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        самые новые заявки - сверху
        $dataProvider->setSort([
            'defaultOrder' => [ 'date_created' => SORT_DESC],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $errorString ='';
            foreach($this->errors as $item) {
                $errorString =  $errorString . " " .  $item[0];
            }
            debug($errorString);die;
            return $dataProvider;
        }

        // Проверка группы сбера в заявке и в справочнике групп сбера
//        if (Requests::getRole() != 'admin') {
        // $dataProvider->query->where('`requests`.`sberwg` = `workgroups`.`wg_name_sber`');
//        $dataProvider->query->where('`requests`.`sberassignee` IN (SELECT * FROM (SELECT `assigneetobank`.`assignee_sber` FROM `assigneetobank`) AS SUBQ)');
//        }


//Парсим данные создаём запрос
//        created
        if(!Empty($params['RequestsSearch']['date_created'])) {
            $dataRange = explode(" - ", $params['RequestsSearch']['date_created']);
            $date_de_from = strtotime($dataRange[0]);
            $date_de_to = strtotime($dataRange[1]);

//Если выбран диапазон
            if($date_de_from != $date_de_to){
                $query->andFilterWhere(['between', 'date_created',$date_de_from,$date_de_to+86399]);
            }
//Иначе ищем за сутки
            else{
                $query->andFilterWhere(['between', 'date_created',$date_de_from,$date_de_to+86399]);
            }

        }
        else{
            $query->andFilterWhere([
                'date_created' => $this->date_created,
            ]);
        }

//        deadline
        if(!Empty($params['RequestsSearch']['date_deadline'])) {
            $dataRange = explode(" - ", $params['RequestsSearch']['date_deadline']);
            $date_de_from = strtotime($dataRange[0]);
            $date_de_to = strtotime($dataRange[1]);

//Если выбран диапазон
            if($date_de_from != $date_de_to){
                $query->andFilterWhere(['between', 'date_deadline',$date_de_from,$date_de_to+86399]);
            }
//Иначе ищем за сутки
            else{
                $query->andFilterWhere(['between', 'date_deadline',$date_de_from,$date_de_to+86399]);
            }
        }
        else{
            $query->andFilterWhere([
                'date_deadline' => $this->date_deadline,
            ]);
        }

//        done
        if(!Empty($params['RequestsSearch']['date_done'])) {
            $dataRange = explode(" - ", $params['RequestsSearch']['date_done']);
            $date_de_from = strtotime($dataRange[0]);
            $date_de_to = strtotime($dataRange[1]);

//Если выбран диапазон
            if($date_de_from != $date_de_to){
                $query->andFilterWhere(['between', 'date_done',$date_de_from,$date_de_to+86399]);
            }
//Иначе ищем за сутки
            else{
                $query->andFilterWhere(['between', 'date_done',$date_de_from,$date_de_to+86399]);
            }
        }
        else{
            $query->andFilterWhere([
                'date_done' => $this->date_done,
            ]);
        }

//        метод выше
        $this->setSidebarFilter($query);

        $query->andFilterWhere(['like', 'sb_id', $this->sb_id])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'full_descr', $this->full_descr])
            ->andFilterWhere(['like', 'solution', $this->solution])
            ->andFilterWhere(['like', 'workgroup_id', $this->workgroup_id])
            ->andFilterWhere(['like', 'assignee', $this->assignee])
            ->andFilterWhere(['like', 'company_id', $this->company_id]);

            // ->andFilterWhere(['like', 'workgroups.wg_name_sber', $this->sberwg]);
        return $dataProvider;
    }
}

