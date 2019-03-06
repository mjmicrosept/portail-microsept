<?php
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 27/02/2019
 * Time: 09:57
 */

use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\assets\components\BootstrapContextMenu\ContextMenuAsset;

ContextMenuAsset::register($this);

$urlUpdateCommentaire = Url::to(['/ADV/echeancier/update-commentaire']);

$this->registerJS(<<<JS
    var url = {
        updateCommentaire:'{$urlUpdateCommentaire}',
    };
JS
);

$this->registerCss(<<<CSS
    .filter-header {
        font-weight:bold;
        vertical-align: middle;
    }
    .kv-grouped-row {
        color: #73818f !important;
        background-color: #d9d9d9 !important;
        border: 1px solid #f4f4f4;
    }
    .table-hover .kv-grouped-row:hover{
        color: #73818f !important;
        background-color: #d9d9d9 !important;
        border: 1px solid #f4f4f4;
        /*color: #fff !important;
        background-color: #00c0ef !important;*/
    }
    
    .kv-grouped-child-row {
        color: #FFF !important;
        background-color: #009cc1 !important;
        border: 1px solid #f4f4f4;
        padding-left:30px !important;
    }
    .table-hover .kv-grouped-child-row:hover{
        color: #FFF !important;
        background-color: #009cc1 !important;
        border: 1px solid #f4f4f4;
        padding-left:30px !important;
        cursor:pointer;
        /*color: #fff !important;
        background-color: #00c0ef !important;*/
    }
    
    .kv-grouped-labo-row {
        color: #000 !important;
        background-color: #8cbeef !important;
        border: 1px solid #f4f4f4;
        padding-left:60px !important;
    }
    .table-hover .kv-grouped-labo-row:hover{
        color: #000 !important;
        background-color: #8cbeef !important;
        border: 1px solid #f4f4f4;
        padding-left:60px !important;
        cursor:pointer;
        /*color: #fff !important;
        background-color: #00c0ef !important;*/
    }
    
    td.kv-group-odd {
        background-color: #d4e2e5 !important;
        border: 1px solid #f4f4f4;
    }
    td.kv-group-even {
        background-color: #d4e2e5 !important;
        border: 1px solid #f4f4f4;
    }

    table.kv-grid-table > tbody > tr:hover{
        background-color:#e4e7ea !important;
        cursor:pointer;
    }
    .primary-content{
        background-color:#6cc7e6 !important;
    }
    
    .dropdown-menu-context{
        width:250px !important;
        display:none;
    }

    .dropdown-menu-context > li > a{
        padding: 5px 20px;
    }
    
    .dropdown-menu-context > li > a:hover{
        text-decoration:none;
        background-color: rgb(32, 168, 216);
        color: rgb(255, 255, 255);
    }
    

CSS
);

?>
<div id="context-menu">
    <ul class="dropdown-menu-context" role="menu">
        <li><a tabindex="-1" href="#">Ajouter/modifier un commentaire</a></li>
    </ul>
</div>
<?= GridView::widget([
    'id' => 'echeance-grid',
    'pjax' => true,
    'pjaxSettings' => [
        'options'=>[
            'id'=>'echeance-grid-pjax'
        ]
    ],
    'hover' => true,
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['class' => 'context line_'.$model['id'].'','data-toggle'=>'context','data-target'=>'#context-menu','data-uuid'=>$model['uuid'],'data-bddid'=>$model['id']];
    },
    'columns' => $gridColumns
]);


$this->registerJS(<<<JS
    //Menu contextuel pour la transformation en avoirs
    $('.context').contextmenu({
      target:'#context-menu',
      before: function(e,context) {
        // execute code before context menu if shown
        return true;
      }, 
      onItem: function(context,e) {
        // execute on menu item selection
        //On vérifie si plusieurs lignes sont concernées
        swal({
            title :'Ajout/modification',
            showCancelButton: true,
            confirmButtonText: 'Valider',
            cancelButtonText: 'Annuler',
            width: 500,
            allowEnterKey:false,
            allowOutsideClick:false,
            allowEscapeKey:false,
            type:'info',
            html:
           '<h3>Ajouter/modifier un commentaire</h3>' + 
           '<textarea id="reason" class="form-control"></textarea>',
           preConfirm: function() {
                    return new Promise(function(resolve) {
                       resolve([
                            document.getElementById('reason').value,
                        ]);
                    });
                }
        }).then(function(result) {
            if(result){
                $('.elite-loader').show();
                var data = JSON.stringify({
                    bddid : context[0].dataset.bddid,
                    uuid : context[0].dataset.uuid,
                    commentaire : result[0],
                });
                $.post(url.updateCommentaire, {data:data}, function(response) {
                    if(response.error == false){
                        $('.line_' + context[0].dataset.bddid + ' > td.commentaire').html(response.commentaire);
                        $('.elite-loader').hide();
                    }
                    else{
                        $('.elite-loader').hide();
                        swal(
                          'Erreur',
                          'Une erreur est survenue, veuillez contacter un administrateur.',
                          'error'
                        )
                    }
                })
            }
        });
      }
    })
JS
);


?>
