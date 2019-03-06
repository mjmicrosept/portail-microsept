<?php

namespace app\controllers\ADV;

use Yii;
use yii\filters\VerbFilter;
use app\models\AppCommon;
use yii\helpers\Json;
use yii\web\Response;
use yii\data\ArrayDataProvider;
use app\models\ADV\AdvEcheancier;
use kartik\grid\GridView;


class EcheancierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('../../adv/index',[
            'extractList' => $this->getExtractionListView(false)
        ]);
    }

    /**
     * Chargement de la liste des extraction après chaque import de données
     * @return array
     */
    public function actionLoadExtractListView(){
        $result = $this->getExtractionListView(true);
        return ['result'=>$result];
    }

    /**
     * Suppression de données d'extraction
     * @return array
     */
    public function actionDeleteExtraction(){
        $errors = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $_data = Json::decode($_POST['data']);
        $listExtraction = $_data['listExtraction'];

        foreach ($listExtraction as $extract) {
            Yii::trace($extract);
            if(!$extraction = AdvEcheancier::deleteAll(
                'uuid = :uuid',
                [':uuid'=>$extract]
            )){
                $errors = true;
            }
        }

        return ['error'=>$errors];
    }

    /**
     * Affichage de la liste des extractions
     * @param $jsonParser
     * @return string
     */
    public function getExtractionListView($jsonParser){
        if($jsonParser)
            Yii::$app->response->format = Response::FORMAT_JSON;
        $extractionList = AdvEcheancier::find()->select(['distinct(uuid)','min(date_extraction) as date_extraction'])->groupBy('uuid')->orderBy('date_extraction')->all();

        $result = '';
        foreach ($extractionList as $extract) {
            $year = substr($extract->date_extraction, 0, 4);
            $month = substr($extract->date_extraction, 5, 2);
            $day = substr($extract->date_extraction, 8, 2);

            $result .= '<input type="checkbox" class="btn-chk-list-extraction" name="extractionList[]" value="'.$extract->uuid.'" style="margin-right:5px;" />';
            $result .= '<i class="fa fa-eye data-view" style="cursor:pointer;color:#3c8dbc;margin-right:5px;" data-uuid="'.$extract->uuid.'" data-libelle="'.$day .' '. AppCommon::$aListMonthComplet[$month] .' '. $year.'"></i>';
            $result .= 'Le '. $day .' '. AppCommon::$aListMonthComplet[$month] .' '. $year;
            //$result .= $extract->uuid;
            $result .= '<br/>';
        }
        return $result;
    }

    /**
     * Chargement de la liste des résultats d'une extraction
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionLoadDataResult(){
        if(isset($_POST['data'])) {
            $_data = Json::decode($_POST['data']);
            $_SESSION['echeancier'] = $_POST['data'];
        }
        else{
            $_data = Json::decode($_SESSION['echeancier']);
        }

        $sql = '';
        $sqlSommeMontant = '';
        $uuid = null;
        $montant = null;
        $dateEcheance = null;
        $nbRelance = null;
        $dateRelance = null;
        $error = false;
        $data = [];

        if(isset($_data['uuid']))
            $uuid = $_data['uuid'];
        if(isset($_data['montant']) && $_data['montant'] != '')
            $montant = floatval($_data['montant']);
        if(isset($_data['dateEcheance']) && $_data['dateEcheance'] != ''){
            $dateEcheance = $_data['dateEcheance'];
            $year = substr($dateEcheance, 6, 4);
            $month = intval(substr($dateEcheance, 3, 2));
            $day = substr($dateEcheance, 0, 2);
            $dateEcheance = $year . '-' . $month . '-' . $day;
        }
        if(isset($_data['nbRelance']) && $_data['nbRelance'] != '')
            $nbRelance = floatval($_data['nbRelance']);
        if(isset($_data['dateRelance']) && $_data['dateRelance'] != ''){
            $dateRelance = $_data['dateRelance'];
            $year = substr($dateRelance, 6, 4);
            $month = intval(substr($dateRelance, 3, 2));
            $day = substr($dateRelance, 0, 2);
            $dateRelance = $year . '-' . $month . '-' . $day;
        }

        if(!is_null($uuid)){
            //Construction des données en fonction des filtres
            $connection = Yii::$app->db;

            $sqlSommeMontant = "(SELECT SUM(montant) FROM adv_echeancier AS adv1 WHERE adv1.uuid = '".$uuid."' AND adv1.client = adv2.client) AS somme_montant,";

            $sql .= "SELECT " . $sqlSommeMontant . " adv2.*,adv2.commentaire as test FROM adv_echeancier AS adv2 WHERE adv2.uuid = '".$uuid."'";
            if(!is_null($dateEcheance))
                $sql .= " AND date_echeance >= '".$dateEcheance."'";
            if(!is_null($nbRelance))
                $sql .= " AND relance = ".$nbRelance."";
            if(!is_null($dateRelance))
                $sql .= " AND date_relance >= '".$dateRelance."'";
            if(!is_null($montant))
                $sql .= " HAVING somme_montant > ".$montant." ";

            $sql .= "ORDER BY adv2.client,adv2.date_facture";

            $aAdvEcheancier = $connection->createCommand($sql)->queryAll();

            foreach ($aAdvEcheancier as $advEcheancier) {
                if (!isset($data[$advEcheancier['id']])) {
                    $data[$advEcheancier['id']]['id'] = $advEcheancier['id'];
                    $data[$advEcheancier['id']]['client'] = $advEcheancier['client'];
                    $data[$advEcheancier['id']]['num_facture'] = $advEcheancier['num_facture'];
                    $data[$advEcheancier['id']]['relance'] = $advEcheancier['relance'];
                    $data[$advEcheancier['id']]['montant'] = floatval($advEcheancier['montant']);
                    $data[$advEcheancier['id']]['date_facture'] = $advEcheancier['date_facture'];
                    $data[$advEcheancier['id']]['date_echeance'] = $advEcheancier['date_echeance'];
                    $data[$advEcheancier['id']]['date_relance'] = $advEcheancier['date_relance'];
                    $data[$advEcheancier['id']]['uuid'] = $advEcheancier['uuid'];
                    $data[$advEcheancier['id']]['commentaire'] = $advEcheancier['commentaire'];
                    $data[$advEcheancier['id']]['somme_montant'] = $advEcheancier['somme_montant'];
                }
            }

            $dataProvider = new ArrayDataProvider([
                'key'=>function($row) {
                    return $row['client'];
                },
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 100,
                ]
            ]);

            $gridColumns = [
                [
                    'label' => 'Client',
                    'format' => 'raw',
                    'value' => function($row) {
                        return $row['client'];
                    },
                    'headerOptions' => ['style'=>'background-color:#20a8d8;'],
                    'contentOptions' => ['style'=>'font-weight:bold'],
                    'group'=>true,  // enable grouping,
                    'groupedRow'=>true,                    // move grouped column to a single grouped row
                    'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
                    'groupFooter' => function ($model, $key, $index, $widget) { // Closure method
                        return [
                            'mergeColumns' => [[1,2]], // columns to merge in summary
                            'content' => [             // content to show in each summary cell
                                1 => 'Somme des montants',
                                3 => sprintf("%0.2f&nbsp;€", floatval($model['somme_montant'])),
                            ],
                            'contentFormats' => [      // content reformatting for each summary cell
                                //3 => ['format' => 'number', 'decimals' => 2],
                            ],
                            'contentOptions' => [      // content html attributes for each summary cell
                            ],
                            // html attributes for group summary row
                            'options' => ['class' => 'context info table-info','style' => 'font-weight:bold;'],
                        ];
                    },
                ],
                [
                    'headerOptions' => ['style'=>'background-color:#20a8d8;color:#FFF;'],
                    'label' => 'N° Fact',
                    'value' => function($row) {
                        return $row['num_facture'];
                    },
                ],
                [
                    'headerOptions' => ['style'=>'background-color:#20a8d8;color:#FFF;'],
                    'label' => 'Date facture',
                    'value' => function($row) {
                        $year = substr($row['date_facture'], 0, 4);
                        $month = intval(substr($row['date_facture'], 5, 2));
                        $day = substr($row['date_facture'], 8, 2);

                        $tMonths = [1 => "Jan", 2 => "Fév", 3 => "Mars", 4 => "Avr", 5 => "Mai", 6 => "Juin", 7 => "Juil", 8 => "Août", 9 => "Sept", 10 => "Oct", 11 => "Nov", 12 => "Déc"];

                        return $day . ' ' . $tMonths[$month] . ' ' . $year;
                    },
                ],
                [
                    'headerOptions' => ['style'=>'background-color:#20a8d8;color:#FFF;'],
                    'label' => 'Montant',
                    'value' => function($row) {
                        return sprintf("%0.2f&nbsp;€", floatval($row['montant']));
                    },
                    'format' => 'raw',
                    'pageSummary' => true,
                ],
                [
                    'headerOptions' => ['style'=>'background-color:#20a8d8;color:#FFF;'],
                    'label' => 'Date échéance',
                    'value' => function($row) {
                        $year = substr($row['date_echeance'], 0, 4);
                        $month = intval(substr($row['date_echeance'], 5, 2));
                        $day = substr($row['date_echeance'], 8, 2);

                        $tMonths = [1 => "Jan", 2 => "Fév", 3 => "Mars", 4 => "Avr", 5 => "Mai", 6 => "Juin", 7 => "Juil", 8 => "Août", 9 => "Sept", 10 => "Oct", 11 => "Nov", 12 => "Déc"];

                        return $day . ' ' . $tMonths[$month] . ' ' . $year;
                    },
                ],
                [
                    'headerOptions' => ['style'=>'background-color:#20a8d8;color:#FFF;'],
                    'label' => 'Nb relances',
                    'value' => function($row) {
                        if($row['relance'] != '')
                            return $row['relance'];
                        else
                            return '0';
                    },
                ],
                [
                    'headerOptions' => ['style'=>'background-color:#20a8d8;color:#FFF;'],
                    'label' => 'Date relance',
                    'value' => function($row) {
                        if($row['date_relance'] != '') {
                            $year = substr($row['date_relance'], 0, 4);
                            $month = intval(substr($row['date_relance'], 5, 2));
                            $day = substr($row['date_relance'], 8, 2);

                            $tMonths = [1 => "Jan", 2 => "Fév", 3 => "Mars", 4 => "Avr", 5 => "Mai", 6 => "Juin", 7 => "Juil", 8 => "Août", 9 => "Sept", 10 => "Oct", 11 => "Nov", 12 => "Déc"];

                            return $day . ' ' . $tMonths[$month] . ' ' . $year;
                        }
                        else{
                            return '-';
                        }
                    },
                ],
                [
                    'headerOptions' => ['style'=>'background-color:#20a8d8;color:#FFF;'],
                    'label' => 'Commentaire',
                    'format'=>'raw',
                    'value' => function($row) {
                        if($row['commentaire'] != '')
                            return $row['commentaire'];
                        else
                            return '';
                    },
                    'contentOptions' => function($row) {
                        return ['class' => 'commentaire'];
                    },
                ],
            ];
        }
        else{
            $error = true;
        }

        if(!$error){
            return $this->renderAjax('../../adv/grid-echeance', [
                'dataProvider' => $dataProvider,
                'gridColumns' => $gridColumns
            ]);
        }
        else {
            return 'une erreur';
        }
    }

    public function actionUpdateCommentaire(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $error = false;
        $commentaire = '';
        Yii::trace($_POST['data']);
        if(isset($_POST['data'])) {
            $_data = Json::decode($_POST['data']);
            $bddid = $_data['bddid'];
            $uuid = $_data['uuid'];
            $commentaire = $_data['commentaire'];

            $advEcheancier = AdvEcheancier::find()->andFilterWhere(['id'=>$bddid])->one();
            $advEcheancier->commentaire = $commentaire;
            if(!$advEcheancier->save()){
                $error = true;
            }
        }
        else{
            $error = true;
        }

        return ['error' => $error,'commentaire'=>$commentaire];
    }

    /**
     * Upload des fichiers de données
     * @return array
     */
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
