<?php

namespace app\commands\take;


use App\Services\Poedem\PoedemService;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class DataForWideController extends Controller
{
    public function actionIndex()
    {
        $poedemService = new PoedemService;

        $poedemService->setUrl('https://poedem.kz/find-form/get-data-for-wide');
        $poedemService->setContent();

        $poedemService->apply();

        dd($poedemService);
//cities
//countries
//directions
//regions
//meals
//defaultDays

        foreach ($content as $table => $datas) {
            foreach ($datas as $data) {
                dd($data);

                $sql = "INSERT INTO {$table} (column1, column2) VALUES (:value1, :value2) ON DUPLICATE KEY UPDATE column1 = :value1, column2 = :value2";

                Yii::$app->db->createCommand($sql, [
                    ':value1' => $value1,
                    ':value2' => $value2
                ])->execute();
            }
        }


        return ExitCode::OK;
    }
}