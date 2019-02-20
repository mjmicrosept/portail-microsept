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
    ],
    ['label' => 'Clients', 'icon' => 'far fa-address-book nav-icon', 'url' => ['/client/index']],
    ['label' => 'Prospects', 'icon' => 'far fa-address-card nav-icon', 'url' => ['/site/7']],
    [
        'label' => 'Suivi commercial',
        'icon' => 'fas fa-briefcase nav-icon',
        'url' => '#',
        'items' => [
            ['label' => 'Chiffre d\'affaire', 'icon' => 'fas fa-funnel-dollar nav-margin-for-menu', 'url' => ['/site/8']],
            ['label' => 'Projets', 'icon' => 'far fa-lightbulb nav-margin-for-menu', 'url' => ['/site/9']],
            ['label' => 'Synthèses', 'icon' => 'fas fa-chart-pie nav-margin-for-menu', 'url' => ['/site/10']],
            ['label' => 'Archives', 'icon' => 'fas fa-archive nav-margin-for-menu', 'url' => ['/site/11']],
        ]
    ],
    ['label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt nav-icon', 'url' => ['/site/dashboard'],'badge' => 'badge badge-info','info'=>'NEW'],
];
