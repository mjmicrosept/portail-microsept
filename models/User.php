<?php

namespace app\models;

use webvimark\modules\UserManagement\components\AuthHelper;
use Yii;
use yii\db\ActiveQuery;
use yii\rbac\Assignment;
use yii\db\Query;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $email_confirmed
 * @property string $auth_key
 * @property string $password_hash
 * @property string $confirmation_token
 * @property string $bind_to_ip
 * @property string $registration_ip
 * @property integer $status
 * @property integer $superadmin
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \webvimark\modules\UserManagement\models\User
{

    const LEVEL_SUPERADMIN = 1;
    const LEVEL_RESP_COMMERCIAL = 2;
    const LEVEL_COMMERCIAL = 3;
    const LEVEL_ADV = 4;
    const LEVEL_RESP_FORMATION = 5;
    const LEVEL_FORMATION = 6;
    const LEVEL_PRELEVEMENT  = 7;

    const TYPE_SUPERADMIN = 'superadmin';
    const TYPE_RESP_COMMERCIAL = 'resp_commercial';
    const TYPE_COMMERCIAL = 'commercial';
    const TYPE_ADV = 'adv';
    const TYPE_RESP_FORMATION = 'resp_formation';
    const TYPE_FORMATION = 'formation';
    const TYPE_PRELEVEMENT = 'prelevement';


    public static $aAssignmentType = [
        self::TYPE_SUPERADMIN => self::LEVEL_SUPERADMIN,
        self::TYPE_RESP_COMMERCIAL  => self::LEVEL_RESP_COMMERCIAL,
        self::TYPE_COMMERCIAL  => self::LEVEL_COMMERCIAL,
        self::TYPE_ADV => self::LEVEL_ADV,
        self::TYPE_RESP_FORMATION => self::LEVEL_RESP_FORMATION,
        self::TYPE_FORMATION => self::LEVEL_FORMATION,
        self::TYPE_PRELEVEMENT => self::LEVEL_PRELEVEMENT
    ];


    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getClient()
    {
        $portailUser = PortailUsers::find()->andFilterWhere(['id_user'=>$this->id])->one();
        if(!is_null($portailUser))
            return Client::find()->andFilterWhere(['id'=>$portailUser->id_client])->one();
        else
            return null;
    }


    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getPortalAssign()
    {
        return PortailUsers::find()->andFilterWhere(['id_user'=>$this->id])->one();
    }


    /**
     * Get assignments for user
     *
     * @param int $userId
     * @return array
     */
    public function getAssignments($userId)
    {
        if (empty($userId)) {
            return [];
        }

        $query = (new Query)
            ->from(Yii::$app->getModule('user-management')->auth_assignment_table)
            ->where(['user_id' => (string) $userId]);

        $assignments = [];
        foreach ($query->all() as $row) {
            $assignments[$row['item_name']] = new Assignment([
                'userId' => $row['user_id'],
                'roleName' => $row['item_name'],
                'createdAt' => $row['created_at'],
            ]);
        }

        return $assignments;
    }

    public static function getUserAssignment($userId){
        if(empty($userId)){
            return null;
        }
        $assignment = (new Query)
            ->from(Yii::$app->getModule('user-management')->auth_assignment_table)
            ->where(['user_id' => (string) $userId])->one();
        if(is_null($assignment))
            return null;
        else
            return $assignment['item_name'];
    }

    public function getLevel() {
        return self::$aAssignmentType[self::getUserAssignment($this->id)];
    }

    public static function getUserLevel($userId) {
        return self::$aAssignmentType[self::getUserAssignment($userId)];
    }

    private function isRole($userId, $role) {
        //Get list of assignments for this user
        $assignments = self::getAssignments(($userId));
        foreach($assignments as $assignment){
            if($assignment->roleName === Yii::$app->params[$role])
                return true;
        }
        return false;
    }

    public static function getRole($userId) {
        //Get list of assignments for this user
        $assignments = self::getAssignments(($userId));
        foreach($assignments as $assignment){
            return $assignment->roleName;
        }
        return null;
    }

    /**
     * Determines whether the user is a superadmin
     *
     * @param int $userId
     * @return bool
     */
    public static function isSuperAdmin($userId){
        return self::isRole($userId,'roleSuperAdmin');
    }

    /**
     * Determines whether the user is a portail admin
     *
     * @param int $userId
     * @return bool
     */
    public static function isRespCommercial($userId){
        return self::isRole($userId,'roleRespCommercial');
    }
    /**
     * Determines whether the user is a labo admin
     *
     * @param int $userId
     * @return bool
     */
    public static function isCommercial($userId){
        return self::isRole($userId,'roleCommercial');
    }
    /**
     * Determines whether the user is a labo user
     *
     * @param int $userId
     * @return bool
     */
    public static function isAdv($userId){
        return self::isRole($userId,'roleAdv');
    }

    /**
     * Determines whether the user is a client admin
     *
     * @param int $userId
     * @return bool
     */
    public static function isRespFormation($userId){
        return self::isRole($userId,'roleRespFormation');
    }

    /**
     * Determines whether the user is a client user
     *
     * @param int $userId
     * @return bool
     */
    public static function isFormation($userId){
        return self::isRole($userId,'roleFormation');
    }

    /**
     * Determines whether the user is a client user group
     *
     * @param int $userId
     * @return bool
     */
    public static function isPrelevement($userId){
        return self::isRole($userId,'rolePrelevement');
    }

    /**
     * Assign role to user
     *
     * @param int  $userId
     * @param string $roleName
     * @return bool
     * @throws \Exception $e
     */
    public static function assignRole($userId, $roleName)
    {
        try
        {
            Yii::$app->db->createCommand()
                ->insert(Yii::$app->getModule('user-management')->auth_assignment_table, [
                    'user_id' => $userId,
                    'item_name' => $roleName,
                    'created_at' => time(),
                ])->execute();

            AuthHelper::invalidatePermissions();

            return true;
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Crée l'utilisateur et ses permissions associées
     * @param $request_post
     * @return bool
     * @throws \yii\db\Exception
     */
    public function createUserWithPermission($request_post){
        $transaction = self::getDb()->beginTransaction();
        $error = false;
        try{
            if(!$this->save())
                $error = true;
            switch($request_post['radioPermission']){
                case User::TYPE_RESP_COMMERCIAL:
                    if (!User::assignRole($this->id, User::TYPE_RESP_COMMERCIAL))
                        $error = true;
                    break;
                case User::TYPE_COMMERCIAL:
                    if (!User::assignRole($this->id, User::TYPE_COMMERCIAL))
                        $error = true;
                    break;
                case User::TYPE_ADV:
                    if (!User::assignRole($this->id, User::TYPE_ADV))
                        $error = true;
                    break;
                case User::TYPE_RESP_FORMATION:
                    if (!User::assignRole($this->id, User::TYPE_RESP_FORMATION))
                        $error = true;
                    break;
                case User::TYPE_FORMATION:
                    if (!User::assignRole($this->id, User::TYPE_FORMATION))
                        $error = true;
                    break;
                case User::TYPE_PRELEVEMENT:
                    if (!User::assignRole($this->id, User::TYPE_PRELEVEMENT))
                        $error = true;
                    break;
            }
            if(!$error)
                $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            $error = true;
        }

        return !$error;
    }


    /**
     * Met à jour l'utilisateur et ses permissions associées
     * @param $request_post
     * @param $old_role
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function updateUserWithPermission($request_post,$old_role){
        $transaction = self::getDb()->beginTransaction();
        $error = false;
        try{
            if(!$this->save())
                $error = true;
            switch($request_post['radioPermission']){
                case User::TYPE_RESP_COMMERCIAL:
                    if(User::revokeRole($this->id, $old_role)) {
                        if (!User::assignRole($this->id, User::TYPE_RESP_COMMERCIAL))
                            $error = true;
                    }
                    break;
                case User::TYPE_COMMERCIAL:
                    if(User::revokeRole($this->id, $old_role)) {
                        if (!User::assignRole($this->id, User::TYPE_COMMERCIAL))
                            $error = true;
                    }
                    break;
                case User::TYPE_ADV:
                    if(User::revokeRole($this->id, $old_role)) {
                        if (!User::assignRole($this->id, User::TYPE_ADV))
                            $error = true;
                    }
                    break;
                case User::TYPE_RESP_FORMATION:
                    if(User::revokeRole($this->id, $old_role)) {
                        if (!User::assignRole($this->id, User::TYPE_RESP_FORMATION))
                            $error = true;
                    }
                    break;
                case User::TYPE_FORMATION:
                    if(User::revokeRole($this->id, $old_role)) {
                        if (!User::assignRole($this->id, User::TYPE_FORMATION))
                            $error = true;
                    }
                    break;
                case User::TYPE_PRELEVEMENT:
                    if(User::revokeRole($this->id, $old_role)) {
                        if (!User::assignRole($this->id, User::TYPE_PRELEVEMENT))
                            $error = true;
                    }
                    break;
            }
            if(!$error)
                $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            $error = true;
        }

        return !$error;
    }

    /**
     * Supprime un utilisateur et ses permissions associées
     * @param $id
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function deleteUserWithPermission($id){
        $transaction = self::getDb()->beginTransaction();
        $error = false;
        try{
            if(!$this->delete())
                $error = true;

            //PortailUsers::deleteEntry($id);

            if(!$error)
                $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            $error = true;
        }

        return !$error;
    }


    /**
     * Renvoie les items du menu User
     * @return array
     */
    public static function menuItems()
    {
        return [
            ['label' => '<i class="fa fa-angle-double-right"></i> ' . Yii::t('menu', 'Users'), 'url' => ['/user-management/user/index']],
            ['label' => '<i class="fa fa-angle-double-right"></i> ' . Yii::t('menu', 'Roles'), 'url' => ['/user-management/role/index']],
            ['label' => '<i class="fa fa-angle-double-right"></i> ' . Yii::t('menu', 'Permissions'), 'url' => ['/user-management/permission/index']],
            ['label' => '<i class="fa fa-angle-double-right"></i> ' . Yii::t('menu', 'Permission groups'), 'url' => ['/user-management/auth-item-group/index']],
            ['label' => '<i class="fa fa-angle-double-right"></i> ' . Yii::t('menu', 'Visit log'), 'url' => ['/user-management/user-visit-log/index']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'username'           => Yii::t('microsept', 'Login'),
            'superadmin'         => Yii::t('microsept', 'Superadmin'),
            'confirmation_token' => 'Confirmation Token',
            'registration_ip'    => Yii::t('microsept', 'Registration IP'),
            'bind_to_ip'         => Yii::t('microsept', 'Bind to IP'),
            'status'             => Yii::t('microsept', 'Status'),
            'gridRoleSearch'     => Yii::t('microsept', 'Roles'),
            'created_at'         => Yii::t('microsept', 'created_at'),
            'updated_at'         => Yii::t('microsept', 'updated_at'),
            'password'           => Yii::t('microsept', 'Password'),
            'repeat_password'    => Yii::t('microsept', 'Repeat password'),
            'email_confirmed'    => Yii::t('microsept', 'E-mail confirmed'),
            'email'              => 'E-mail',
        ];
    }

    /**
     * getStatusList
     * @return array
     */
    public static function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE   => Yii::t('microsept', 'Active'),
            self::STATUS_INACTIVE => Yii::t('microsept', 'Inactive'),
        );
    }

    public function rules()
    {
        $rules =  [

        ];
        return array_merge(parent::rules(), $rules);
    }
}
