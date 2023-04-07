<?php


namespace App\Service;


use App\Models\LessonCategory;
use App\Models\PurchaseLogs;
use Illuminate\Support\Facades\Redis;

class PurchaseLogService
{
    public static function makeFake()
    {
        $logs = PurchaseLogs::query()->get();
        $categories = collect(LessonCategory::query()->get())->toArray();
        foreach ($logs as $log){
            $amount = getDeposit(random_int(2000,40000));
            $categoryIndex = random_int(1,count($categories)-1);
            $category = $categories[$categoryIndex];
            $log->{PurchaseLogs::FIELD_AMOUNT} = $amount;
            $log->{PurchaseLogs::FIELD_LESSON_CATEGORY} = $category["name"];
            $log->save();
        }
    }

    public function getAll()
    {
        $logs = PurchaseLogs::query()->get([
            PurchaseLogs::FIELD_NICKNAME,
            PurchaseLogs::FIELD_LESSON_CATEGORY,
            PurchaseLogs::FIELD_AMOUNT
        ]);
        $result = [];
        $data = collect($logs)->toArray();
        for ($i=0;$i<=200;$i++){
            $index = random_int(0,199);
            $log = $data[$index];
            array_push($result,"用户{$log[PurchaseLogs::FIELD_NICKNAME]}，刚刚购买了【{$log[PurchaseLogs::FIELD_LESSON_CATEGORY]}】课包，支付订金{$log[PurchaseLogs::FIELD_AMOUNT]}元");
        }

        return $result;
    }

}
