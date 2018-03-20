<?php

namespace app\models\transport;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RequestsTransportSearch represents the model behind the search form about `app\models\Requests`.
 */
class RequestsTransportSearch extends RequestsTransport
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
            [['sb_id', 'descr', 'full_descr', 'solution', 'workgroup_id', 'assignee', 'workgroups','sberwg','closure_code','bank_contact','bank_contact_phone','date_created','date_done','date_deadline','ride_end_time','ride_duration','ride_idle_time','ride_distance','ride_price'], 'safe'],
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
        if ($this->getAction() == 'index' && RequestsTransport::getRole() != 'admin') {
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

        if ($this->getAction() == 'pricesent') {
            # Показывать с отправленной ценой
            $querypar->andFilterWhere([
                'assignee' => Yii::$app->user->id,
                'status' => 100
            ]);
        }

        if ($this->getAction() == 'rejected') {
            $querypar->andFilterWhere([
                'requests.company_id' => Yii::$app->user->identity->company_id
            ]);
            # Только отозванные
            $querypar->andFilterWhere(['=', 'closure_code', 3]);
            $querypar->andFilterWhere(['=', 'status', 8]);
        }
}

//    метод для кнопок следующ\предыдущ
    public function NextOrPrev($currentId)
    {
        if ($this->getPrevPage() == 'index') {

            $records = RequestsTransport::find()->select(['requests.id'])->where(['=', 'company_id', Yii::$app->user->identity->company_id])->andwhere(['<', 'status', 7])->all();
        }
        if ($this->getPrevPage() == 'my') {

            $records = RequestsTransport::find()->select(['requests.id'])->where(['=', 'assignee', Yii::$app->user->id])->andwhere(['<', 'status', 7])->all();
        }
        if ($this->getPrevPage() == 'mydone') {

            $records = RequestsTransport::find()->select(['requests.id'])->where(['=', 'assignee', Yii::$app->user->id])->andwhere(['=', 'status', 7])->all();
        }
        if ($this->getPrevPage() == 'rejected') {

            $records = RequestsTransport::find()->select(['requests.id'])->where(['=', 'company_id', Yii::$app->user->identity->company_id])->andwhere(['=', 'closure_code', 3])->all();
        }
        if ($this->getPrevPage() == 'pricesent') {

            $records = RequestsTransport::find()->select(['requests.id'])->where(['=', 'company_id', Yii::$app->user->identity->company_id])->andwhere(['=', 'status', 100])->all();
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
        //транспорт
//        взять в работу
        if ($button_id == 10) {
            $user_id = Yii::$app->user->id;
            $assignee = $user_id;
            return ['assignee' => $assignee];
        }

//        Назначить авто
        if ($button_id == 11) {
            $status = $model->status;
            $driver_id = $model->driver_id;
            $params = Yii::$app->request->post('RequestsTransport');
            $driver_id_param = $params['driver_id'];
            if ($driver_id == '') {
                Yii::$app->session->setFlash('nosolution', "Нужно выбрать водителя!");
            }
            else {
                $driver_id = $driver_id_param;
                $status = 5;
            }
            return [
                'driver_id' => $driver_id,
                'status' => $status
            ];
        }

//        Поездка завершена
        if ($button_id == 12) {
            $status = $model->status;
            $driver_id = $model->driver_id;
            $solution = $model->solution;
            $closure_code = $model->closure_code;
            $ride_end = $model->ride_end_time;
            $params = Yii::$app->request->post('RequestsTransport');
            $driver_id_param = $params['driver_id'];
            $solution_param = $params['solution'];
            $closure_code_param = $params['closure_code'];
            $ride_end_param = $params['ride_end_time'];
            if ($driver_id == '') {
                Yii::$app->session->setFlash('nosolution', "Ошибка! Нужно выбрать водителя!");
            }
            elseif ($ride_end_param == '') {
                Yii::$app->session->setFlash('nosolution', "Ошибка! Заполните время завершения поезки!");
            }
            elseif ($solution_param == '' or $closure_code_param == '') {
                Yii::$app->session->setFlash('nosolution', "Ошибка! Заполните решение и код закрытия!");
            }
            else {
                $driver_id = $driver_id_param;
                $status = 7;
                $solution = $solution_param;
                $closure_code = $closure_code_param;
                $ride_end = $ride_end_param;

            }
            return [
                'driver_id' => $driver_id,
                'status' => $status,
                'solution' => $solution,
                'closure_code' => $closure_code,
                'ride_end_time' => $ride_end

            ];
        }

        //        Передать данные поездки
        if ($button_id == 13) {
            $status = $model->status;
            $ride_duration = $model->ride_duration;
            $ride_distance = $model->ride_distance;
            $ride_idle_time = $model->ride_idle_time;
            $ride_price = $model->ride_price;
            $params = Yii::$app->request->post('RequestsTransport');
            $ride_duration_param = $params['ride_duration'];
            $ride_price_param = $params['ride_price'];
            $ride_idle_time_param = $params['ride_idle_time'];
            $ride_distance_param = $params['ride_distance'];
            if ($ride_duration_param == '' or $ride_price_param == '' or $ride_idle_time_param == '' or $ride_distance_param == '') {
                Yii::$app->session->setFlash('nosolution', "Нужно заполнить все данные о поездке!");
            }
            else {
                $ride_duration = $ride_duration_param;
                $ride_price = $ride_price_param;
                $ride_idle_time = $ride_idle_time_param;
                $ride_distance = $ride_distance_param;
                $status = 100;
            }
            return [
                'ride_duration' => $ride_duration,
                'ride_distance' => $ride_distance,
                'ride_idle_time' => $ride_idle_time,
                'ride_price' => $ride_price,
                'status' => $status
            ];
        }
    }

    public function search($params)
    {
        $query = RequestsTransport::find();
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
//            debug($errorString);die;
            return $dataProvider;
        }

        // Проверка группы сбера в заявке и в справочнике групп сбера
//        if (RequestsTransport::getRole() != 'admin') {
        // $dataProvider->query->where('`requests`.`sberwg` = `workgroups`.`wg_name_sber`');
//        $dataProvider->query->where('`requests`.`sberassignee` IN (SELECT * FROM (SELECT `assigneetobank`.`assignee_sber` FROM `assigneetobank`) AS SUBQ)');
//        }


//Парсим данные создаём запрос
//        created
        if(!Empty($params['RequestsTransportSearch']['date_created'])) {
            $dataRange = explode(" - ", $params['RequestsTransportSearch']['date_created']);
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
        if(!Empty($params['RequestsTransportSearch']['date_deadline'])) {
            $dataRange = explode(" - ", $params['RequestsTransportSearch']['date_deadline']);
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
        if(!Empty($params['RequestsTransportSearch']['date_done'])) {
            $dataRange = explode(" - ", $params['RequestsTransportSearch']['date_done']);
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

