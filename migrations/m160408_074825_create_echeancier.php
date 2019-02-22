<?php
/**
 * Created by PhpStorm.
 * User: JMaratier
 * Date: 20/02/2019
 * Time: 16:23
 */

use yii\db\Migration;

class m160408_074825_create_echeancier extends Migration
{
    public function up()
    {
        $this->createTable('adv_echeancier', [
            'id' => $this->primaryKey(),
            'client' => $this->string(255)->notNull(),
            'num_facture' => $this->string(50)->defaultValue(NULL),
            'relance' => $this->integer(11),
            'montant' => $this->string(25)->defaultValue(NULL),
            'date_facture' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'date_echeance' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'date_relance' => $this->timestamp()->defaultValue(NULL),
            'date_extraction' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'uuid' => $this->string(255)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('adv_echeancier');
    }
}