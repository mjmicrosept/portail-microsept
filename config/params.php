<?php

return [
    'adminEmail' => 'admin@example.com',
    'bsVersion' => '3.x',

    //ASSIGNMENTS
    'roleSuperAdmin' => 'super_admin',
    'roleRespCommercial'=>'resp_commercial',
    'roleCommercial'=>'commercial',
    'roleAdv'=>'adv',
    'roleRespFormation'=>'resp_formation',
    'roleFormation'=>'formation',
    'rolePrelevement'=>'prelevement',

    //PATH DOSSIERS CLIENTS
    'dossierAdmin'=>dirname(__DIR__) .'/web/dossiers_clients/admin/',
    'dossierTemplate'=>dirname(__DIR__) .'/web/dossiers_clients/admin/template',
    'dossierClients'=>dirname(__DIR__) .'/web/dossiers_clients/actifs/',
    'dossierArchive'=>dirname(__DIR__) .'/web/dossiers_clients/archive/',
    'dossierRoot'=>dirname(__DIR__) .'/web/dossiers_clients/',

    //URL DOSSIERS CLIENTS
    'urlAdmin'=>Yii::$app->request->baseUrl .'/dossiers_clients/admin/',
    'urlTemplate'=>Yii::$app->request->baseUrl .'/dossiers_clients/admin/template',
    'urlClients'=>Yii::$app->request->baseUrl .'/dossiers_clients/actifs/',
    'urlArchive'=>Yii::$app->request->baseUrl .'/dossiers_clients/archive/',
    'urlRoot'=>Yii::$app->request->baseUrl .'/dossiers_clients/',


    'arboClientFirstYear'=>2007,
    //DONNEES ADV
    'adv' => [
        'pathEcheance' => dirname(__DIR__) .'/web/dossier_adv/Echeances/',
        'urlEcheance' => Yii::$app->request->baseUrl .'/dossier_adv/Echeances/',
    ],

    //MODE DECONNECTE
    'disconnectMode'=> false,
    'ftp-analyses' => [
        'host' => '127.0.0.1',
        'login' => 'jmaratier',
        'password' => 'Microsept49',
        'fileAnalyse' => 'COMPILATIONANALYSES.csv',
    ],
    'services'=>[
        'generique'=>5
    ]

];
