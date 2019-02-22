<?php
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 20/02/2019
 * Time: 15:15
 */

return [
    'class' => 'yii\db\Connection',
//    'dsn' => 'sqlsrv:Server=localhost;MultipleActiveResultSets=true;Database=Bijou',
//    'dsn' => 'sqlsrv:Server=25.111.1.148;MultipleActiveResultSets=true;Database=FROGERFLEURS',
    //'dsn' => 'sqlsrv:Server=25.49.255.136;MultipleActiveResultSets=true;Database=Celtileg',
//    'dsn' => 'sqlsrv:Server=25.49.255.136;MultipleActiveResultSets=true;Database=CeltiSaalv_test',
//    'dsn' => 'sqlsrv:Server=25.49.255.136;MultipleActiveResultSets=true;Database=Celtileg',
    //'dsn' => 'sqlsrv:Server=25.49.255.136;MultipleActiveResultSets=true;Database=CeltiSaalv3',
    //'dsn' => 'sqlsrv:Server=localhost;MultipleActiveResultSets=true;Database=CELTILEG',
    'dsn' => 'sqlsrv:Server=localhost;MultipleActiveResultSets=true;Database=Personnes',

//    'connectionString' => 'sqlsrv:Server=25.128.130.116;MultipleActiveResultSets=true;Database=MDE_DOS_SOC01',
    'username' => 'Satellite',
    'password' => 'uQxwKU2uDUYsC5U9',
    'charset' => 'utf8',
    'enableQueryCache' => true,
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600*24,
];