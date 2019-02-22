<?php
/**
 * Created by PhpStorm.
 * User: Jean-Baptiste
 * Date: 12/05/2015
 * Time: 01:14
 */

use app\models\User;


return [
    ['label' => 'THEME'],
    [
        'label' => 'Utilisateurs',
        'url' => '#',
        'icon' => 'fas fa-users nav-icon',
        'items' => [
            ['label' => 'Utilisateurs', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['/user-management/user/index']],
            ['label' => 'Rôles', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['/user-management/role/index']],
            ['label' => 'Permissions', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['/user-management/permission/index']],
            ['label' => 'Grps de permission', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['/user-management/auth-item-group/index']],
            ['label' => 'Journal des visites', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['/user-management/user-visit-log/index']],
        ],
        'visible' => Yii::$app->user->isSuperAdmin
    ],
    [
        'label' => 'Super Admin',
        'url' => '#',
        'icon' => 'fa fa-wrench nav-icon',
        'items' => [
            ['label' => ' Gii','icon' => 'fa fa-file-code-o nav-margin-for-menu', 'url' => ['/gii']],
            ['label' => 'Debug','icon' => 'fa fa-dashboard nav-margin-for-menu', 'url' => ['/debug']],
            ['label' => ''. Yii::t('microsept','Taches planifiees').'','icon' => 'fa fa-clock-o nav-margin-for-menu', 'url' => ['/cron']],
        ],
        'visible' => Yii::$app->user->isSuperAdmin
    ],
    //['label' => 'Clients', 'icon' => 'far fa-address-book nav-icon', 'url' => ['/client/index']],
    //['label' => 'Prospects', 'icon' =>     'far fa-address-card nav-icon', 'url' => ['/site/7']],
    [
        'label' => 'Suivi commercial',
        'icon' => 'fas fa-briefcase nav-icon',
        'url' => '#',
        'items' => [
            ['label' => 'Chiffre d\'affaire', 'icon' => 'fas fa-funnel-dollar nav-margin-for-menu', 'url' => ['/site/8']],
            ['label' => 'Projets', 'icon' => 'far fa-lightbulb nav-margin-for-menu', 'url' => ['/site/9']],
            ['label' => 'Synthèses', 'icon' => 'fas fa-chart-pie nav-margin-for-menu', 'url' => ['/site/10']],
            ['label' => 'Archives', 'icon' => 'fas fa-archive nav-margin-for-menu', 'url' => ['/site/11']],
        ],
        'visible' => Yii::$app->user->isSuperAdmin || User::getCurrentUser()->hasRole([User::TYPE_RESP_COMMERCIAL]),
    ],
    [
        'label' => 'A.D.V',
        'icon' => 'fas fa-briefcase nav-icon',
        'url' => '#',
        'items' => [
            ['label' => 'Echéances', 'icon' => 'fas fa-funnel-dollar nav-margin-for-menu', 'url' => ['/ADV/echeancier/index']],
            ['label' => 'Archives', 'icon' => 'fas fa-archive nav-margin-for-menu', 'url' => ['/site/9']],
            ['label' => 'Contrats', 'icon' => 'fas fa-chart-pie nav-margin-for-menu', 'url' => ['/site/10']],
        ],
        'visible' => Yii::$app->user->isSuperAdmin || User::getCurrentUser()->hasRole([User::TYPE_ADV]),
    ],
    ['label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt nav-icon', 'url' => ['/site/dashboard'],'badge' => 'badge badge-info','info'=>'NEW'],
];
