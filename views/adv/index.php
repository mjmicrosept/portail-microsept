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

FormAsset::register($this,View::POS_HEAD);
FileInputAsset::register($this);
KartikCommonAsset::register($this);
SweetAlertAsset::register($this);

$baseUrl = Yii::$app->request->baseUrl;
$urlFileUpload = Url::to(['/ADV/echeancier/file-upload']);

$this->registerJS(<<<JS
    var url = {
        fileUpload:'{$urlFileUpload}',
    };
JS
);

$this->title = Yii::t('microsept', 'Echeances');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row" style="padding:0px 10px">
    <div class="col-sm-6 col-md-6 card-upload">
        <div class="card" style="border:1px solid #acb5bd">
            <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd;font-weight:bold;">Importer un fichier
                <div class="card-header-actions">
                    <a class="card-header-action btn-setting" href="#">
                        <i class="fas fa-cog"></i>
                    </a>
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
                    <a class="card-header-action btn-setting" href="#">
                        <i class="fas fa-cog"></i>
                    </a>
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
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding:0px 10px">
    <div class="col-sm-12 col-md-12">
        <div class="card" style="border:1px solid #acb5bd">
            <div class="card-header bg-secondary" style="border-bottom:1px solid #acb5bd;font-weight:bold;">Résultats
                <div class="card-header-actions">

                </div>
            </div>
            <div class="row" style="margin:0;">
                <div class="card-body col-sm-2 col-md-2" style="text-align:center;border-right:1px solid #acb5bd;padding:10px 0;">
                    <label>Montant total</label>
                    <input type="text" />
                    <br/><br/>
                    <label>Date d'échéance</label>
                    <input type="text" />
                    <br/><br/>
                    <button class="btn btn-primary">Filtrer</button>
                </div>
                <div class="card-body col-sm-10 col-md-10">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJS(<<<JS
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
    })
    
    $('.btn-close-extraction').click(function(){
        $('.card-extraction').hide(500);
    })
JS
);
