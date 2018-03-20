<div id="left-panel" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
    <ul class="nav nav-pills nav-stacked">
        <li class="active" role="presentation"><a id="filterName" href="#filters" data-toggle="collapse">Фильтры</a></li>
        <?php if (isset($this->params['controlButtonsAccess']) && $this->params['controlButtonsAccess']) { ?>
            <li role="presentation"><a href="/admin"> Админка</a></li>
        <?php } ?>
    </ul>

    <div class="tab-content">
        <div id="filters" class="collapse in" aria-expanded="true">
            <div class="tab-pane fade in active">
                <ul id="filters" class="nav nav-pills nav-stacked fav-data">
                    <?php
                    //  Меню для эксплуатации
                    if ($service_type == 1) {  ?>
                    <li <?php if($currentPath === 'reqexpl/index' || $currentPath === '' || $prevPage === 'index'){echo 'class="active"';} ?> ><a href="/reqexpl/index" id="linkWg"><i class="fa fa-users" aria-hidden="true"></i> &nbsp;На мои рабочие группы</a></li>
                    <li <?php if($currentPath === 'reqexpl/my' || $prevPage === 'my'){echo 'class="active"';} ?>><a id="linkMy" href="/reqexpl/my"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp;Назначены мне</a></li>
                    <li <?php if($currentPath === 'requests/mydone' || $prevPage === 'mydone' || $prevPage === 'mydone'){echo 'class="active"';} ?>><a id="linkDoneMe" href="/reqexpl/mydone"><i class="fa fa-check-circle" aria-hidden="true"></i> &nbsp;Выполненные мной</a></li>
                    <li <?php if($currentPath === 'reqexpl/rejected' || $prevPage === 'rejected'){echo 'class="active"';} ?>><a id="cancelClient" href="/reqexpl/rejected"><i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp;Отозваны клиентом</a></li>

                    <?php
                    //  Меню для транспорта
                    } elseif ($service_type == 2) {  ?>
                    <li <?php if($currentPath === 'reqtr/index' || $currentPath === '' || $prevPage === 'index'){echo 'class="active"';} ?> ><a href="/reqtr/index" id="linkWg"><i class="fa fa-users" aria-hidden="true"></i> &nbsp;На мои рабочие группы</a></li>
                    <li <?php if($currentPath === 'reqtr/my' || $prevPage === 'my'){echo 'class="active"';} ?>><a id="linkMy" href="/reqtr/my"><i class="fa fa-user-circle-o" aria-hidden="true"></i> &nbsp;Назначены мне</a></li>
                    <li <?php if($currentPath === 'requests/mydone' || $prevPage === 'mydone'){echo 'class="active"';} ?>><a id="linkDoneMe" href="/reqtr/mydone"><i class="fa fa-check-circle" aria-hidden="true"></i> &nbsp;Завершенные поездки</a></li>
                    <li <?php if($currentPath === 'requests/pricesent' || $prevPage === 'pricesent'){echo 'class="active"';} ?>><a id="dataSend" href="/reqtr/pricesent"><i class="fa fa-check-circle" aria-hidden="true"></i> &nbsp;Данные отправлены</a></li>
                    <li <?php if($currentPath === 'reqtr/rejected' || $prevPage === 'rejected'){echo 'class="active"';} ?>><a id="cancelClient" href="/reqtr/rejected"><i class="fa fa-times-circle" aria-hidden="true"></i> &nbsp;Отозваны клиентом</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
//    справочники только для транспортного сервиса
        if ($service_type == 2) {
            ?>
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"><a id="optionTransportName" href="#optionTransport" data-toggle="collapse">Справочники</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="optionTransport" class="collapse in" aria-expanded="true">

                    <ul id="handbooks" class="nav nav-pills nav-stacked fav-data">
                        <li <?php if (strpos(Yii::$app->request->url,'transport/driver')) {
                            echo 'class="active"';
                        } ?> ><a id="iconDriver" href="/transport/driver"><i class="fa fa-id-card-o" aria-hidden="true"></i>&nbsp&nbsp Водители</a>
                        </li>
                        <li <?php if (strpos(Yii::$app->request->url,'transport/car')) {

                            echo 'class="active"';
                        } ?> ><a id="iconCar" href="/transport/car"><i class="fa fa-car" aria-hidden="true"></i>&nbsp&nbsp
                                Автомобили</a></li>
                    </ul>
                </div>
            </div>
            <?php
        }
    ?>
    <div id="show-panel"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></div>
</div>
