<?php
/**
 * Created by PhpStorm.
 * User: Jean-Baptiste
 * Date: 12/05/2015
 * Time: 01:14
 */

use app\models\User;


return [
    /*[
        'label' => '<a href="#"><i class="fa fa-user"></i>
                                    <span>Gestion des Utilisateurs</span>
                                <i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => ' treeview'],
        'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
        'items' => Yii::$app->getModule('user-management')->menuItems(),
    ],
    [
        'label' => '<a href="#"><i class="fa fa-wrench"></i>
                                    <span>Super Admin</span>
                                <i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => ' treeview'],
        'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
        'items' => [
            ['label' => '<span class="fa fa-file-code-o"></span> Gii', 'url' => ['/gii']],
            ['label' => '<span class="fa fa-dashboard"></span> Debug', 'url' => ['/debug']],
            ['label' => '<span class="fa fa-clock-o"></span> '. Yii::t('microsept','Taches planifiees'), 'url' => ['/cron']],
        ],
        'visible' => Yii::$app->user->isSuperAdmin
    ],
    [
        'label' => '<a href="#"><i class="fas fa-cog"></i>
                                    <span>Paramétrage</span>
                                <i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => ' treeview'],
        'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
        'items' => [
            ['label' => '<span class="fas fa-project-diagram"></span> Services', 'url' => ['/analyse-service/index']],
            ['label' => '<span class="fas fa-check"></span> Conformités', 'url' => ['/analyse-conformite/index']],
            ['label' => '<span class="fas fa-american-sign-language-interpreting"></span> Interprétations', 'url' => ['/analyse-interpretation/index']],
            ['label' => '<span class="fas fa-boxes"></span> Conditionnements', 'url' => ['/analyse-conditionnement/index']],
            ['label' => '<span class="fas fa-syringe"></span> Lieux de prélèvements', 'url' => ['/analyse-lieu-prelevement/index']],
            ['label' => '<span class="fas fa-exchange-alt"></span> Liaisons identifiants clients', 'url' => ['/mappage-id-client/index']],
            //['label' => '<span class="fas fa-vials"></span> Germes', 'url' => ['/analyse-germe/index']],
        ],
        'visible' => Yii::$app->user->isSuperAdmin || User::getCurrentUser()->hasRole([User::TYPE_PORTAIL_ADMIN])
    ],
    [
        'label' => '<a href="#"><i class="fa fa-flask"></i>
                                    <span>Laboratoires</span>
                                <i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => ' treeview'],
        'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
        'items' => [
            ['label' => '<span class="fa fa-list"></span> Liste', 'url' => ['/labo/index']],
            ['label' => '<span class="fa fa-exchange"></span> Affectation clients', 'url' => ['/labo/affectation']],
        ],
    ],
    [
        'label' => '<a href="#"><i class="'.$clientIcon.'"></i>
                                    <span>'.$clientLabel.'</span>
                                <i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => ' treeview'],
        'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
        'items' => [
            ['label' => '<span class="fa fa-list"></span> Liste', 'url' => ['/client/index']],
        ],
        'visible'=>$visibleClient
    ],
    [
        'label' => '<a href="#"><i class="fa fa-file"></i>
                                    <span>Documents</span>
                                <i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => ' treeview'],
        'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
//        'linkTemplate' => '<a target="{target}" href="{url}">{label}</a>',
        'items' => [
            //['label' => '<span class="fa fa-folder-open"></span> Arborescence', 'url' => ['/document/arborescence'],'visible' => Yii::$app->user->isSuperAdmin],
            ['label' => '<span class="fas fa-cloud-upload-alt"></span> Envoi des documents', 'url' => ['/document/upload']],
            ['label' => '<span class="fa fa-tag"></span> Résultats d\'analyses', 'url' => ['/document/result-analyse-index']],
            ['label' => '<span class="fas fa-book"></span> Logs', 'url' => ['/log-labo-documents-delete/index']],
        ],
//        'visible' => Yii::$app->user->isSuperAdmin
    ],
    [
        'label' => '<a href="#"><i class="fas fa-microscope"></i>
                                    <span>Consultation des résultats</span>
                                <i class="fa fa-angle-left pull-right"></i></a>',
        'options' => ['class' => ' treeview'],
        'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
//        'linkTemplate' => '<a target="{target}" href="{url}">{label}</a>',
        'items' => [
            //['label' => '<span class="fa fa-folder-open"></span> Arborescence', 'url' => ['/document/arborescence'],'visible' => Yii::$app->user->isSuperAdmin],
            ['label' => '<span class="fas fa-table"></span> Synthèse',
                'url' => ['/synthese/index'],
                //'visible'=>true
                'visible' => !User::getCurrentUser()->hasRole([User::TYPE_LABO_ADMIN]) && !User::getCurrentUser()->hasRole([User::TYPE_LABO_USER]) ? true : Yii::$app->user->isSuperAdmin  ? true : false
            ],
            ['label' => '<span class="fas fa-cloud-upload-alt"></span> Envoi des données', 'url' => ['/analyse-data/upload']],
            ['label' => '<span class="fas fa-chart-pie"></span> Statistiques', 'url' => ['/analyse-data/statistique'],'visible'=>Yii::$app->user->isSuperAdmin ? true : false],
        ],
    ],*/
    ['label' => 'THEME'],
    [
        'label' => 'Utilisateurs',
        'url' => '#',
        'icon' => 'fas fa-users nav-icon',
        'items' => [
            ['label' => 'Utilisateurs', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['site/1']],
            ['label' => 'Rôles', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['site/2']],
            ['label' => 'Permissions', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['site/3']],
            ['label' => 'Grps de permission', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['site/4']],
            ['label' => 'Journal des visites', 'icon' => 'fas fa-bullseye nav-margin-for-menu', 'url' => ['site/5']],
        ],
    ],
    ['label' => 'Clients', 'icon' => 'far fa-address-book nav-icon', 'url' => ['site/6']],
    ['label' => 'Prospects', 'icon' => 'far fa-address-card nav-icon', 'url' => ['site/7']],
    [
        'label' => 'Suivi commercial',
        'icon' => 'fas fa-briefcase nav-icon',
        'url' => '#',
        'items' => [
            ['label' => 'Chiffre d\'affaire', 'icon' => 'fas fa-funnel-dollar nav-margin-for-menu', 'url' => ['site/8']],
            ['label' => 'Projets', 'icon' => 'far fa-lightbulb nav-margin-for-menu', 'url' => ['site/9']],
            ['label' => 'Synthèses', 'icon' => 'fas fa-chart-pie nav-margin-for-menu', 'url' => ['site/10']],
            ['label' => 'Archives', 'icon' => 'fas fa-archive nav-margin-for-menu', 'url' => ['site/11']],
        ]
    ],
    ['label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt nav-icon', 'url' => ['site/dashboard']],
];
/*$result = [];
array_push($result,['label' => 'THEME']);
return $result;*/