<?php

namespace App\Controller\Component;

use Cake\Controller\Controller;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use PhpParser\Node\Expr\Empty_;

class CustomComponent extends Component
{

    public function GetUsertoken($result = null)
    {
        if (!empty($result)) {
            $Usertoken = '';
            if (!empty($result['token'])) {
                $Usertoken = $result['token'];
            }
            return $Usertoken;
        }
    }


    public function GetUserDataById($id)
    {
        if (!empty($id)) {
            $usertable = TableRegistry::getTableLocator()->get('Users');
            $user = $usertable->find()
                ->select([
                    'id' => 'users.id',
                    'token' => 'users.token',
                    'email' => 'users.email',
                    'address' => 'users.address',
                    'phone' => 'users.phone',
                    'name' => 'users.name',
                    'role' => 'ur.ur_name'
                ])
                ->join([
                    'ur' => ([
                        'table' => 'users_role',
                        'type' => 'INNER',
                        'conditions' => 'ur.id = users.user_role_id'
                    ])
                ])
                ->from('users')
                ->where([
                    'users.id' => $id
                ])
                ->toArray();
            return $user;
        }
    }
    public function GetUserData($token)
    {
        if (!empty($token)) {
            $usertable = TableRegistry::getTableLocator()->get('Users');
            $user = $usertable->find()
                ->select([
                    'id' => 'users.id',
                    'token' => 'users.token',
                    'email' => 'users.email',
                    'address' => 'users.address',
                    'verified' => 'users.verified',
                    'phone' => 'users.phone',
                    'image' => 'users.image',
                    'name' => 'users.name',
                    'type' => 'ut.ut_name',
                    'role' => 'ur.ur_name',
                    'role_id' => 'users.user_role_id',
                    'status' => 'users.status',
                    'type_id' => 'users.user_type_id'
                ])
                ->join([
                    'ur' => ([
                        'table' => 'users_role',
                        'type' => 'INNER',
                        'conditions' => 'ur.id = users.user_role_id'
                    ]),
                    'ut' => ([
                        'table' => 'users_type',
                        'type' => 'INNER',
                        'conditions' => 'ut.id = users.user_type_id'
                    ])
                ])
                ->from('users')
                ->where([
                    'users.token' => $token
                ])
                ->first();
            return $user;
        }
    }

    public function getOrderStatus($orderId)
    {

        $Orderstable = TableRegistry::getTableLocator()->get('Orders');
        $OdersData = $Orderstable->find()
            ->where([
                'id' => $orderId
            ])->first();

        $status = '';

        if ($OdersData->status == 0) {
            $status = '<span class="text-danger">??????????????????</span>';
        }
        if ($OdersData->status == 1) {
            $status = '<span class="text-muted">???????????????????????????????????????</span>';
        }
        if ($OdersData->status == 2) {
            $status = '<span class="text-primary">????????????????????????????????????</span>';
        }
        if ($OdersData->status == 3) {
            $status = '<span class="text-primary">????????????????????????????????????</span>';
        }
        if ($OdersData->status == 4) {
            $status = '<span class="text-muted">??????????????????????????????????????????</span>';
        }
        if ($OdersData->status == 5) {
            $status = '<span class="text-success">??????????????????????????????</span>';
        }


        echo $status;
    }



    public function getPostsType()
    {
        $table = TableRegistry::getTableLocator()->get('PostsType');
        $getPostsType = $table->find('all');
        return $getPostsType;
    }



    public function getFileGroup()
    {
        $table = TableRegistry::getTableLocator()->get('FileGroup');
        $getFileGroup = $table->find('all')->toArray();
        return $getFileGroup;
    }

    public function getUserRole()
    {
        $table = TableRegistry::getTableLocator()->get('UsersRole');
        $getUserRole = $table->find('all')->toArray();
        return $getUserRole;
    }

    public function getUserType()
    {
        $table = TableRegistry::getTableLocator()->get('UsersType');
        $getUserType = $table->find('all')->toArray();
        return $getUserType;
    }

    public function getEventGroup()
    {
        $table = TableRegistry::getTableLocator()->get('EventsType');
        $getEventGroup = $table->find('all')->toArray();
        return $getEventGroup;
    }



    public function countVisiter()
    {
        $table = TableRegistry::getTableLocator()->get('Webstat');
        $countProduct = $table->find()->count();
        return $countProduct;
    }
    public function countNews()
    {
        $table = TableRegistry::getTableLocator()->get('Posts');
        $countNews = $table->find()->count();
        return $countNews;
    }
    public function countUsers()
    {
        $table = TableRegistry::getTableLocator()->get('Users');
        $countBranch = $table->find()->count();
        return $countBranch;
    }

    public function getUsersId()
    {
        $session = $this->request->getSession();
        $Userloginsession =  $session->read('Userlogin');
    }

    public function countPostsViews()
    {
        $table = TableRegistry::getTableLocator()->get('Posts');
        $countPostsViews = $table->find()->select([
            'views' => 'SUM(Posts.p_views)'
        ])->toArray();
        return $countPostsViews;
    }


    public function countBanner()
    {
        $table = TableRegistry::getTableLocator()->get('Banner');
        $countBanner = $table->find()->count();
        return $countBanner;
    }
    public function countActive()
    {
        $table = TableRegistry::getTableLocator()->get('Banner');
        $countActive = $table->find()->where(['status' => 1])->count();
        return $countActive;
    }
    public function countUnActive()
    {
        $table = TableRegistry::getTableLocator()->get('Banner');
        $countUnActive = $table->find()->where(['status' => 0])->count();
        return $countUnActive;
    }

    public function countNewsUnActive()
    {
        $table = TableRegistry::getTableLocator()->get('Newsletter');
        $countUnActive = $table->find()->where(['status' => 0])->count();
        return $countUnActive;
    }
    public function countNewsActive()
    {
        $table = TableRegistry::getTableLocator()->get('Newsletter');
        $countActive = $table->find()->where(['status' => 1])->count();
        return $countActive;
    }
    public function countNewsDownload()
    {
        $table = TableRegistry::getTableLocator()->get('Newsletter');
        $countPostsViews = $table->find()->select([
            'views' => 'SUM(Newsletter.download)'
        ])->toArray();
        return $countPostsViews;
    }


    public function countEducationUnActive()
    {
        $table = TableRegistry::getTableLocator()->get('Education');
        $countUnActive = $table->find()->where(['status' => 0])->count();
        return $countUnActive;
    }
    public function countEducationActive()
    {
        $table = TableRegistry::getTableLocator()->get('Education');
        $countActive = $table->find()->where(['status' => 1])->count();
        return $countActive;
    }
    public function countEducationDownload()
    {
        $table = TableRegistry::getTableLocator()->get('Education');
        $countPostsViews = $table->find()->select([
            'views' => 'SUM(Education.download)'
        ])->toArray();
        return $countPostsViews;
    }


    public function countFileActive()
    {
        $table = TableRegistry::getTableLocator()->get('File');
        $countActive = $table->find()->where(['status' => 1])->count();
        return $countActive;
    }

    public function countFile()
    {
        $table = TableRegistry::getTableLocator()->get('File');
        $countActive = $table->find()->count();
        return $countActive;
    }
    public function countFileDownload()
    {
        $table = TableRegistry::getTableLocator()->get('File');
        $countPostsViews = $table->find()->select([
            'views' => 'SUM(File.download)'
        ])->toArray();
        return $countPostsViews;
    }



    public function UserLog($id)
    {
        $UserLog = TableRegistry::getTableLocator()->get('Userlog');
        $UserLogSave =  $UserLog->newemptyEntity();
        $UserLogSave->user_id = $id;
        $UserLog->save($UserLogSave);
    }




    public function getUserlogData()
    {
        $table = TableRegistry::getTableLocator()->get('Userlog');
        $getUserlogData = $table->find()->contain(['Users'])->order(['Userlog.id' => 'desc'])->limit(5)->toArray();
        return $getUserlogData;
    }

    public function getUserlogDataAll()
    {
        $table = TableRegistry::getTableLocator()->get('Userlog');
        $getUserlogData = $table->find()->contain(['Users'])->order(['Userlog.id' => 'desc'])->toArray();
        return $getUserlogData;
    }
    public function getPosts()
    {
        $table = TableRegistry::getTableLocator()->get('Posts');
        $getPost = $table->find()->contain(['PostsType'])->order(['Posts.id' => 'desc'])->limit(5)->toArray();
        return $getPost;
    }


    public function CountEvents()
    {
        $table = TableRegistry::getTableLocator()->get('Events');
        $CountEvents = $table->find()->count();
        return $CountEvents;
    }

    public function CountActiveEvents()
    {
        $table = TableRegistry::getTableLocator()->get('Events');
        $Today = date('Y-m-d');

        $CountActiveEvents = $table->find()
            ->where([
                'DATE(`end`) >=' => $Today
            ])->count();

        return $CountActiveEvents;
    }

    public function CountUnActiveEvents()
    {
        $table = TableRegistry::getTableLocator()->get('Events');
        $Today = date('Y-m-d');

        $CountActiveEvents = $table->find()
            ->where([
                'DATE(`end`) <=' => $Today
            ])->count();

        return $CountActiveEvents;
    }

    public function GetContactData()
    {
        $table = TableRegistry::getTableLocator()->get('Contact');
        $GetContactData = $table->find('all')->first();
        return $GetContactData;
    }
    public function countImgActive()
    {
        $table = TableRegistry::getTableLocator()->get('Gallery');
        $countImgActive = $table->find()->where(['status' => 1])->count();
        return $countImgActive;
    }
    public function countImgUnActive()
    {
        $table = TableRegistry::getTableLocator()->get('Gallery');
        $countImgUnActive = $table->find()->where(['status' => 0])->count();
        return $countImgUnActive;
    }

    public function countImg()
    {
        $table = TableRegistry::getTableLocator()->get('Gallery');
        $countImg = $table->find()->count();
        return $countImg;
    }
}
