<?php
namespace Core;
$cacheJson = file_get_contents('cache.json');
$cacheJson = json_decode($cacheJson, true);


if (empty($cacheJson)){
    file_put_contents('cache.json','[]');

}
class CacheClass
{
    public $cacheJson;

    public function __construct($cacheJson)
    {
        $this->cacheJson = $cacheJson;
    }

    public function isUserInCache($id)
    {

        foreach ($this->cacheJson as $item) {
            if ($item['id'] == $id) {
                return true;
            }
        }
        return false;
    }

    public function getUserInfoFromCashe($id)
    {

        if ($this->isUserInCache($id)) {
            foreach ($this->cacheJson as $item) {
                if ($item['id'] == $id) {
                    return $item;
                }
            }
            return $id;
        }

    }


    public function initUser($id)
    {;
        $newUser = [
            "id" => $id,
        ];
        array_push($this->cacheJson, $newUser);
        var_dump($this->cacheJson);

    }

    public function setUserInfoIntoCache($id, $data)
    {
        if ($this->isUserInCache($id)) {
            foreach ($this->cacheJson as $key => $item) {
                if ($item['id'] == $id) {
                    $this->cacheJson[$key] = $data;
                }
            }

        } else {
            echo $id;
        }
    }

    public function setState($id, $state)
    {

        if ($this->isUserInCache($id)) {
            $user = $this->getUserInfoFromCashe($id);
        } else {
            $this->initUser($id);
            $user = $this->getUserInfoFromCashe($id);
        }
        $user['state'] = $state;
       $this->setUserInfoIntoCache($id, $user);
    }

    public function getState($id)
    {
        $user = $this->getUserInfoFromCashe($id);
        if (!isset($user['state'])) {
            setState($id, 'stylist');
        }
        $state = $user['state'];
        return $state;
    }

    public function setStylist($id,$staylist)
    {
        if ($this->isUserInCache($id)) {
            $user = $this->getUserInfoFromCashe($id);
        } else {
            $this->initUser($id);
            $user = $this->getUserInfoFromCashe($id);
        }
        $user['data']['stylist'] = $staylist;
        $this->setUserInfoIntoCache($id, $user);

    }
    public function setDay($id,$day)
    {
        if ($this->isUserInCache($id)) {
            $user = $this->getUserInfoFromCashe($id);
        } else {
            $this->initUser($id);
            $user = $this->getUserInfoFromCashe($id);
        }
        $user['data']['day'] = $day;
        $this->setUserInfoIntoCache($id, $user);

    }

    public function deleteUserFromCache($id)
    {

        foreach ($this->cacheJson as $key => $item) {
            if ($item['id'] == $id) {
                array_splice($this->cacheJson, $key, 1);
            }
        }
    }
    public function getStylistId($id)
    {
        $stylist = $this->getUserInfoFromCashe($id);
        $stylistName = $stylist['data']['stylist'];
        $stylistId = getStylistByName($stylistName)['id'];
        return $stylistId;
    }


    public function setTime($id,$time)
    {
        if ($this->isUserInCache($id)) {
            $user = $this->getUserInfoFromCashe($id);
        } else {
            $this->initUser($id);
            $user = $this->getUserInfoFromCashe($id);
        }
        $user['data']['time'] = $time;
        $this->setUserInfoIntoCache($id, $user);

    }
    public function setPhoneNumber($id,$phoneNumber)
    {
        if ($this->isUserInCache($id)) {
            $user = $this->getUserInfoFromCashe($id);
        } else {
            $this->initUser($id);
            $user = $this->getUserInfoFromCashe($id);
        }
        $user['data']['phoneNumber'] = $phoneNumber;
        $this->setUserInfoIntoCache($id, $user);

    }

}

$Cache = new CacheClass($cacheJson);


$cacheJson = json_encode($Cache->cacheJson);
file_put_contents('cache.json', $cacheJson);

