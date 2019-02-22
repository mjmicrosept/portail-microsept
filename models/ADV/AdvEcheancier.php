<?php

namespace app\models\ADV;

use Yii;

/**
 * This is the model class for table "adv_echeancier".
 *
 * @property int $id
 * @property string $client
 * @property string $num_facture
 * @property int $relance
 * @property string $montant
 * @property string $date_facture
 * @property string $date_echeance
 * @property string $date_relance
 * @property string $date_extraction
 * @property string $uuid
 */
class AdvEcheancier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adv_echeancier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client','uuid'], 'required'],
            [['date_facture', 'date_echeance','date_extraction','date_relance'], 'safe'],
            [['client','uuid'], 'string', 'max' => 255],
            [['num_facture'], 'string', 'max' => 50],
            [['montant'], 'string', 'max' => 25],
            [['relance'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'num_facture' => 'Num Facture',
            'relance' => 'Relance',
            'montant' => 'Montant',
            'date_facture' => 'Date Facture',
            'date_echeance' => 'Date Echeance',
            'date_relance' => 'Date Relance',
            'date_extraction' => 'Date Extraction',
            'uuid' => 'Identifiant Unique'
        ];
    }

    public static function insertAllFromCsv($filename,$name = null,$uuid){
        $file = file($filename);
        $error = false;
        $nbLignes = 0;
        $transaction = self::getDb()->beginTransaction();
        $ligneError = null;

        try {
            $index = 0;
            $aGlobal = [];
            $strGlobal = '';

            //On supprime les tabulations et retour chariot interne aux cellules et place le tout dans une variable qu'on retransformera en tableau pour ne plus avoir de cassure dans les lignes
            foreach ($file as $f) {
                $f = str_replace ("\t", '', $f);
                if(strstr($f, "/\n")) {
                    $f = str_replace ("\n", '', $f);
                }
                $strGlobal .= $f;
            }
            $aGlobal = (explode("\r\n",$strGlobal));

            foreach ($aGlobal as $f) {
                $aColumns = str_getcsv($f, ';');

                if ($index > 1) {
                    //var_dump($aColumns).PHP_EOL;
                    if(isset($aColumns['0'])) {
                        $nbLignes++;
                        //Création des données générales
                        $echeancier = new self();
                        $echeancier->client = html_entity_decode(htmlentities(utf8_encode($aColumns['0']), ENT_QUOTES, "UTF-8"));

                        $echeancier->num_facture = $aColumns['5'];

                        $echeancier->relance = $aColumns['11'];

                        $echeancier->montant = $aColumns['13'];

                        $year = substr($aColumns['14'], 6, 4);
                        $month = intval(substr($aColumns['14'], 3, 2));
                        $day = substr($aColumns['14'], 0, 2);
                        $date_facture = $year . '-' . $month . '-' . $day;
                        $echeancier->date_facture = $date_facture;

                        $year = substr($aColumns['15'], 6, 4);
                        $month = intval(substr($aColumns['15'], 3, 2));
                        $day = substr($aColumns['15'], 0, 2);
                        $date_echeance = $year . '-' . $month . '-' . $day;
                        $echeancier->date_echeance = $date_echeance;

                        $date_relance = null;
                        if($aColumns['16'] != '') {
                            $tDateRelance = explode('/',$aColumns['16']);
                            if(count($tDateRelance) != 1) {
                                $year = substr($aColumns['16'], 6, 4);
                                $month = intval(substr($aColumns['16'], 3, 2));
                                $day = substr($aColumns['16'], 0, 2);
                                $date_relance = $year . '-' . $month . '-' . $day;
                            }
                        }
                        $echeancier->date_relance = $date_relance;

                        $echeancier->uuid = $uuid;


                        if (!$echeancier->save()) {
                            $error = true;
                            $ligneError = $nbLignes;
                        }
                    }
                }
                $index++;
            }

            if(!$error) {
                //On valide l'enregistrement des données
                $transaction->commit();
                //On supprime le fichier
                unlink($filename);
                return $ligneError;
            }
            else {
                $transaction->rollBack();
                //On supprime le fichier
                unlink($filename);
                return $ligneError;
            }
        }catch (\yii\db\IntegrityException $e) {
            $transaction->rollBack();
            //Yii::error($e->getMessage(), 'analyse/importation');
            //echo $e->getMessage();
            //throw $e;
            //On supprime le fichier
            unlink($filename);
            $ligneError = $nbLignes;
            return $ligneError;
        }catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            //Yii::error($e->getMessage(), 'analyse/importation');
            //echo $e->getMessage();
            //throw $e;
            //On supprime le fichier
            unlink($filename);
            $ligneError = $nbLignes;
            return $ligneError;
        }
    }
}
