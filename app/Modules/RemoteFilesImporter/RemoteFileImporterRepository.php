<?php declare(strict_types=1);


namespace App\Modules\RemoteFilesImporter;


use App\Models\Files;
use App\Models\Profile;
use App\Models\Subscription;
use App\Models\UsersClicks;
use App\Models\UsersGeo;
use App\Models\UsersSubscription;
use Carbon\Carbon;
use foo\bar;

final class RemoteFileImporterRepository
{
    /**
     * @param $file_id
     * @param $id
     * @param $email
     * @return int
     */
    public function insertProfile($file_id, $id, $email)
    {
        $profile = Profile::whereProfileId($id)->first();
        if (!isset($profile)) {
            $profile = new Profile();
            $profile->profile_id = $id;
            $profile->file_id = $file_id;
            $profile->email = $email;
            $profile->save();
        }

        return $profile->id;
    }

    /**
     * @param $name
     * @return int
     */
    public function insertFile($name)
    {
        $file = Files::whereFileName($name)->first();
        if (!isset($file)) {
            $file = new Files();
            $file->file_name = $name;
            $file->save();
        }

        return $file->id;
    }

    public function insertGeo($geoArr, $userId)
    {
        UsersGeo::$parentId = 0;
        UsersGeo::$fullArray = $geoArr;
        UsersGeo::saveItem($geoArr, $userId);
        return true;
    }

    public function insertClicks($clicks, $userId)
    {
        foreach ($clicks as $item) {
            $click = UsersClicks::whereUserId($userId)->whereCampaignId($item->campaign_id)->first();
            if (!isset($click)){
                $click = new UsersClicks();
                $click->campaign_id = $item->campaign_id;
                $click->url = $item->url;
                $click->user_id = $userId;
                $click->time = strtotime($item->time->date);
                $click->save();
            }
        }
        return true;
    }

    public function insertSubscription($array, $userId)
    {
        foreach ($array as $item) {
            $sub = Subscription::whereId($item->id)->first();
            if (!isset($sub)) {
                $sub = new Subscription();
                $sub->id = $item->id;
                $sub->name = $item->name;
                $sub->save();
            }

            $userSub = UsersSubscription::whereUserId($userId)->whereSubscriptionId($item->id)->first();
            if(!isset($userSub)) {
                $userSub = new UsersSubscription();
                $userSub->user_id = $userId;
                $userSub->subscription_id = $item->id;
                $userSub->time = strtotime($item->time->date);
                $userSub->save();
            }

        }
        return true;
    }
}
