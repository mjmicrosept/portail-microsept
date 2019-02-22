<?php

namespace app\controllers\ADV;

use Yii;
use yii\filters\VerbFilter;
use app\models\AppCommon;
use yii\helpers\Json;
use yii\web\Response;
use app\models\ADV\AdvEcheancier;

class EcheancierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('../../adv/index');
    }

    public function actionFileUpload(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //Récupération des variables
        $error = [];
        $errorkey = [];
        $uuid = AppCommon::Gen_UUID();


        //Chemin vers le dossier labo
        $pathAdvFolder = Yii::$app->params['adv']['pathEcheance'].$uuid.'/';

        if(!is_dir($pathAdvFolder))
            mkdir($pathAdvFolder);

        for($i = 0; $i < count($_FILES['upload-files']['name']);$i++){
            $aFileExtension = explode(".", $_FILES['upload-files']['name'][$i]);
            if($aFileExtension[count($aFileExtension) -1] == 'csv') {
                $destination = $pathAdvFolder;
                if(!file_exists($destination . $_FILES['upload-files']['name'][$i])) {
                    @copy($_FILES['upload-files']['tmp_name'][$i], $destination . $_FILES['upload-files']['name'][$i]);
                    @unlink($_FILES['files']['tmp_name'][$i]);
                }
            }
            else{
                array_push($error,'Un fichier ne possède pas la bonne extension');
                array_push($errorkey,$i);
            }
        }

        //On insère les données du fichier dans la base de données
        if(count($error == 0)){
            $errorLine = AdvEcheancier::insertAllFromCsv($pathAdvFolder . $_FILES['upload-files']['name'][0],$_FILES['upload-files']['name'][0],$uuid);
            if(!is_null($errorLine)){
                array_push($error, 'L\'importation des données a échouée à la ligne '.$errorLine.'.');
                array_push($errorkey, 0);
            }
            else{
                rmdir($pathAdvFolder);
            }
        }
        //On récupère le nom du dossier client
        return ['error'=>$error, 'errorkeys'=>$errorkey];
    }

}
