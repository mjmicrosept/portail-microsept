<?php
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 20/02/2019
 * Time: 16:59
 */


use yii\web\View;
use yii\helpers\Url;
use kartik\builder\Form;
use kartik\file\FileInput;

use kartik\builder\FormAsset;
use app\assets\views\KartikCommonAsset;
use app\assets\components\SweetAlert\SweetAlertAsset;
use kartik\file\FileInputAsset;
use app\assets\views\EliteDangerousAsset;

FormAsset::register($this,View::POS_HEAD);
FileInputAsset::register($this);
KartikCommonAsset::register($this);
SweetAlertAsset::register($this);
EliteDangerousAsset::register($this);

$baseUrl = Yii::$app->request->baseUrl;
$urlFileUpload = Url::to(['/ADV/echeancier/file-upload']);
$urlDeleteExtraction = Url::to(['/ADV/echeancier/delete-extraction']);
$urlLoadExtractView = Url::to(['/ADV/echeancier/load-extract-list-view']);
$urlLoadDataResult = Url::to(['/ADV/echeancier/load-data-result']);

$this->registerJS(<<<JS
    var url = {
        fileUpload:'{$urlFileUpload}',
        deleteExtraction:'{$urlDeleteExtraction}',
        loadExtractView:'{$urlLoadExtractView}',
        loadDataResult:'{$urlLoadDataResult}',
    };
JS
);

$this->registerCss(<<<CSS
    .main{
        overflow: hidden;
    }

CSS
);


$this->title = Yii::t('microsept', 'Echeances');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="elite-loader">
    <div class="dank-ass-loader">
        <div class="row">
            <div class="arrow up outer outer-18"></div>
            <div class="arrow down outer outer-17"></div>
            <div class="arrow up outer outer-16"></div>
            <div class="arrow down outer outer-15"></div>
            <div class="arrow up outer outer-14"></div>
        </div>
        <div class="row">
            <div class="arrow up outer outer-1"></div>
            <div class="arrow down outer outer-2"></div>
            <div class="arrow up inner inner-6"></div>
            <div class="arrow down inner inner-5"></div>
            <div class="arrow up inner inner-4"></div>
            <div class="arrow down outer outer-13"></div>
            <div class="arrow up outer outer-12"></div>
        </div>
        <div class="row">
            <div class="arrow down outer outer-3"></div>
            <div class="arrow up outer outer-4"></div>
            <div class="arrow down inner inner-1"></div>
            <div class="arrow up inner inner-2"></div>
            <div class="arrow down inner inner-3"></div>
            <div class="arrow up outer outer-11"></div>
            <div class="arrow down outer outer-10"></div>
        </div>
        <div class="row">
            <div class="arrow down outer outer-5"></div>
            <div class="arrow up outer outer-6"></div>
            <div class="arrow down outer outer-7"></div>
            <div class="arrow up outer outer-8"></div>
            <div class="arrow down outer outer-9"></div>
        </div>
    </div>
</div>

<div class="row" style="padding:0px 10px">
    <div class="col-sm-6 col-md-6 card-upload">
        <div class="card" style="border:1px solid #acb5bd">
            <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd;font-weight:bold;">Importer un fichier
                <div class="card-header-actions">
                    <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </a>
                    <a class="card-header-action btn-close-upload" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="collapse show" id="collapseExample">
                <div class="card-body">
                    <div class="file-loading">
                        <input id="upload-input" name="upload-files[]" type="file">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 card-extraction">
        <div class="card" style="border:1px solid #acb5bd">
            <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd;font-weight:bold;">Liste des extractions
                <div class="card-header-actions">
                    <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </a>
                    <a class="card-header-action btn-close-extraction" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="collapse show" id="collapseExample">
                <div class="card-body">
                    <div class="row" style="margin-top:-10px;margin-bottom:10px;float:right;">
                        <div style="float:right;">
                            <button class="btn btn-brand btn-sm btn-twitter" id="supp-selection" type="button" style="margin-bottom: 4px">
                                <i class="fas fa-eraser"></i>
                                <span>Supprimer la sélection</span>
                            </button>
                            <button class="btn btn-brand btn-sm btn-twitter" id="supp-all" type="button" style="margin-bottom: 4px">
                                <i class="fas fa-trash-alt"></i>
                                <span>Tout supprimer</span>
                            </button>
                            <!--<button class="btn btn-primary" id="supp-selection">Supprimer la sélection</button>
                            <button class="btn btn-primary" id="supp-all">Tout supprimer</button>-->
                        </div>
                    </div>
                    <div class="extract-list">
                        <?= $extractList; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding:0px 10px">
    <div class="col-sm-12 col-md-12">
        <div class="card" style="border:1px solid #acb5bd">
            <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd;font-weight:bold;">
                <span id="resultat-libelle">Résultats</span>
                <div class="card-header-actions">
                    <a class="card-header-action btn-import" href="#" style="display:none;">
                        <i class="fas fa-upload"></i>
                    </a>
                    <a class="card-header-action btn-list-extract" href="#" style="display:none;">
                        <i class="fas fa-list-ul"></i>
                    </a>
                </div>
            </div>
            <div class="row view-result" style="margin:0;display:none;">
                <div class="card-body card-filter" style="text-align:center;padding:20px 15px;width:15%;border-right:1px solid #acb5bd;position:relative;">
                    <i class="fas fa-times filter-hide" style="position:absolute;top:2px;right:2px;cursor:pointer;color:#73818f;"></i>
                    <label>Montant total</label>
                    <input type="text" id="filter-montant" class="form-control" />
                    <br/>
                    <?=
                        Form::widget([
                            'formName' => 'kvform',
                            'columns' => 1,
                            'compactGrid' => true,

                            // set global attribute defaults
                            'attributeDefaults' => [
                                'labelOptions' => ['style' => ''],
                                'inputContainer' => ['style' => 'border:none;'],
                            ],
                            'attributes' => [
                                'dateEcheance' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\date\DatePicker',
                                    'options' => [
                                        'options' => [
                                            'placeholder' => '_ _/_ _/_ _ _ _', 'dropdownCssClass' => 'dropdown-vente-livr', 'multiple' => false
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                        ]
                                    ],
                                    'label' => 'Date d\'échéance',
                                ]
                            ]
                        ]);
                    ?>
                    <br/>
                    <label>Nombre relances</label>
                    <input type="text" id="filter-relance" class="form-control" />
                    <br/>
                    <?=
                        Form::widget([
                            'formName' => 'kvform',
                            'columns' => 1,
                            'compactGrid' => true,

                            // set global attribute defaults
                            'attributeDefaults' => [
                                'labelOptions' => ['style' => ''],
                                'inputContainer' => ['style' => 'border:none;'],
                            ],
                            'attributes' => [
                                'dateRelance' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\date\DatePicker',
                                    'options' => [
                                        'options' => [
                                            'placeholder' => '_ _/_ _/_ _ _ _', 'dropdownCssClass' => 'dropdown-vente-livr', 'multiple' => false
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                        ]
                                    ],
                                    'label' => 'Date de relance',
                                ]
                            ]
                        ]);
                    ?>
                    <br/>
                    <input type="hidden" id="select-uuid" />
                    <!--<button class="btn btn-primary">Filtrer</button>-->
                    <button class="btn btn-brand btn-sm btn-twitter" id="btn-filter" type="button" style="margin-bottom: 4px">
                        <i class="fas fa-filter"></i>
                        <span>Filtrer</span>
                    </button>
                </div>
                <div class="card-body"  style="width:84%;position:relative;">
                    <i class="fas fa-filter filter-show" style="position:absolute;top:2px;left:2px;cursor:pointer;color:#73818f;display:none;"></i>
                    <div id="echeance-result">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJS(<<<JS
$(document).ready(function(){
    delegateExtractList();
    /*******************************************************/
    // Init du fileinput
    /*******************************************************/                
    $("#upload-input").fileinput({
        uploadUrl: url.fileUpload,
        uploadAsync: false,
        language:'fr',
        overwriteInitial: false,
        previewThumbTags: {
            '{TAG_VALUE}': '',        // no value
            '{TAG_CSS_NEW}': '',      // new thumbnail input
            '{TAG_CSS_INIT}': 'kv-hidden'  // hide the initial input
        },
        initialPreview: [
        ],
        initialPreviewConfig: [
           
        ],
        initialPreviewThumbTags: [
           
        ],
    });
    
    $('.btn-file > i').removeClass('glyphicon').removeClass('glyphicon-folder-open').addClass('fas').addClass('fa-folder-open');
    $('.fileinput-remove-button > i').removeClass('glyphicon').removeClass('glyphicon-trash').addClass('fas').addClass('fa-trash-alt');
    $('.fileinput-upload-button > i').removeClass('glyphicon').removeClass('glyphicon-upload').addClass('fas').addClass('fa-upload');
    $('.fileinput-cancel-button').hide();
    $('.file-preview').css('display','none');
    $('.hidden-xs').html('');
    
    $("#upload-input").on('filebatchuploadsuccess',function(event,data){
        loadExtractListView();
    });


    /***********************************************************************/
    // Actions sur les box du haut (minifier/supprimer/import/extract-list)
    /***********************************************************************/
    $('.btn-minimize').click(function(){
        if($('.btn-minimize > i').hasClass('fa-angle-up')){
            $('.btn-minimize > i').removeClass('fa-angle-up').addClass('fa-angle-down');
        }
        else{
            $('.btn-minimize > i').removeClass('fa-angle-down').addClass('fa-angle-up');
        }
    })
    
    $('.btn-close-upload').click(function(){
        $('.card-upload').hide(500);
        $('.btn-import').show();
    })
    
    $('.btn-close-extraction').click(function(){
        $('.card-extraction').hide(500);
        $('.btn-list-extract').show();
    })
    
    $('.btn-import').click(function(){
        $(this).hide();
        $('.card-upload').show(500);
    })
    
    $('.btn-list-extract').click(function(){
        $(this).hide();
        $('.card-extraction').show(500);
    })
    
    /*********************************************/
    //Suppression de données
    /*********************************************/
    $('#supp-selection').click(function(){
        suppFiles(false);
    });
    
    $('#supp-all').click(function(){
        suppFiles(true);
    });
    
    function suppFiles(all){
        var question = '<p>Voulez vous supprimer les données d\'extraction sélectionnées ?</p>';
        if(all)
            question = '<p>Voulez vous supprimer toutes les données d\'extraction ?</p>';
        
        var aExtractions = [];
        $('.btn-chk-list-extraction').each(function(){
            if(all){
                aExtractions.push($(this).val());
            }
            else{
                if($(this).prop('checked') == true)
                    aExtractions.push($(this).val());
            }
        });
        if(aExtractions.length == 0){
            swal(
              'Suppression',
              'Aucune extraction n\'est sélectionnée.',
              'error'
            )
        }
        else{
            swal({
                title :'Suppression',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                width: 800,
                allowEnterKey:false,
                allowOutsideClick:false,
                allowEscapeKey:false,
                type:'question',
                html:question,
            }).then(function(result) {
                if(result){
                    $('.elite-loader').show();
                    var data = JSON.stringify({
                        listExtraction:aExtractions,
                    });
                    $.post(url.deleteExtraction, {data:data}, function(response) {
                        if(response.error == false){
                            
                            loadExtractListView();
                            $('.elite-loader').hide();
                            
                            swal(
                              'Suppression réussie',
                              'La suppression s\'est effectuée avec succès.',
                              'success'
                            )
                        }
                        else{
                            swal(
                              'Erreur',
                              'Une erreur est survenue lors de la suppression, veuillez contacter un administrateur.',
                              'error'
                            )
                        }
                    })
                }
            });
        }
    };
    
    function loadExtractListView(){
        var data = JSON.stringify({

        });
        $.post(url.loadExtractView, {data:data}, function(response) {
            if(response.result != ''){
                $('.extract-list').html(response.result);
                delegateExtractList();
            }
            else{
                $('.extract-list').html('Aucun fichier présent.');
            }
        })
    }
    
    /*****************************************************/
    //Action au niveau des filtres
    /****************************************************/
    $('.filter-hide').click(function(){
        $('.filter-show').show();
        $('.card-filter').hide(500);
    });
    
    $('.filter-show').click(function(){
        $(this).hide();
        $('.card-filter').show(500);
    });
    
    /****************************************************/
    // Affichage du tableau de résultats
    /****************************************************/
    //Permet de déléguer le click sur un élément après rajout dans le dom
    function delegateExtractList(){
        $('.extract-list').delegate('.data-view','click',function(){
            var uuid = $(this).data('uuid');
            var resultLibelle = 'Résultats du ' + $(this).data('libelle');
            var data = JSON.stringify({
                uuid : uuid,
            });
            $('#select-uuid').val(uuid);
            
            var montant = $('#filter-montant').val();
            var dateEcheance = $('#kvform-dateecheance').val();
            var nbRelance = $('#filter-relance').val();
            var dateRelance = $('#kvform-daterelance').val();
            if(montant != '' || dateEcheance != '' || nbRelance != '' || dateRelance != ''){
                var question = "Des filtres sont saisis. Voulez-vous les appliquer ?"
                swal({
                    title :'Filtre',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    width: 800,
                    allowEnterKey:false,
                    allowOutsideClick:false,
                    allowEscapeKey:false,
                    type:'question',
                    html:question,
                }).then(function(result) {
                    if(result){
                        $('.elite-loader').show();
                        var montant = $('#filter-montant').val();
                        var dateEcheance = $('#kvform-dateecheance').val();
                        var nbRelance = $('#filter-relance').val();
                        var dateRelance = $('#kvform-daterelance').val();
                        var data = JSON.stringify({
                            uuid : uuid,
                            montant:montant,
                            dateEcheance:dateEcheance,
                            nbRelance:nbRelance,
                            dateRelance:dateRelance
                        });
                        $.post(url.loadDataResult, {data:data}, function(response) {
                            $('#echeance-result').html(response);
                            $('.elite-loader').hide();
                        });
                    }
                },function(dismiss){
                    if (dismiss === 'cancel'){
                        $('.elite-loader').show();
                        $('#filter-montant').val('');
                        $('#kvform-dateecheance').val('');
                        $('#filter-relance').val('');
                        $('#kvform-daterelance').val('');
                        $.post(url.loadDataResult, {data:data}, function(response) {
                            $('#echeance-result').html(response);
                            $('#resultat-libelle').html(resultLibelle);
                            $('.elite-loader').hide();
                        });
                    }
                });
            }
            else{
                $('.elite-loader').show();
                $.post(url.loadDataResult, {data:data}, function(response) {
                    $('#echeance-result').html(response);
                    $('#resultat-libelle').html(resultLibelle);
                    $('.view-result').show();
                    $('.elite-loader').hide();
                });
            }
        })
    }
    
    $('#btn-filter').click(function(){
        var uuid = $('#select-uuid').val();
        if(uuid != ''){
            $('.elite-loader').show();
            var montant = $('#filter-montant').val();
            var dateEcheance = $('#kvform-dateecheance').val();
            var nbRelance = $('#filter-relance').val();
            var dateRelance = $('#kvform-daterelance').val();
            var data = JSON.stringify({
                uuid : uuid,
                montant:montant,
                dateEcheance:dateEcheance,
                nbRelance:nbRelance,
                dateRelance:dateRelance
            });
            $.post(url.loadDataResult, {data:data}, function(response) {
                $('#echeance-result').html(response);
                $('.elite-loader').hide();
            });
        }
        else{
            swal(
              'Info',
              'Aucun fichier n\' a été préalablement choisi',
              'info'
            )
        }
    })
});
JS
);
