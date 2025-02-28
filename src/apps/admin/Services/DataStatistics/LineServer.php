<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/28
 * Time: 10:02
 */

namespace Admin\Services\DataStatistics;

use Admin\Models\Order\Order;
use Admin\Models\User\User;
use Admin\Services\BaseService;
use Common\Models\Collection\Collection;
use Common\Models\Order\RepaymentPlan;
use Common\Utils\Data\DateHelper;
use Common\Utils\Data\MoneyHelper;
use Common\Utils\Data\StatisticsHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LineServer extends BaseService
{
    const TYPE_DAY_REGISTER_SUM = 'day_register_sum';//注册量
    const TYPE_DAY_ORDER_COUNT = 'day_order_count';//订单量
    const TYPE_DAY_PASS_COUNT = 'day_pass_count';//机审通过量
    const TYPE_DAY_REMIT_COUNT = 'day_remit_count';//放款数
    const TYPE_DAY_REMIT_SUM = 'day_remit_sum';//放款金额
    const TYPE_DAY_REPAY_SUM = 'day_repay_sum';//每日还款额
    const TYPE_DAY_OVERDUE_SUM = 'day_overdue_sum';//每日逾期额
    const TYPE = [
        self::TYPE_DAY_REMIT_SUM => '每日放款额',
        self::TYPE_DAY_REPAY_SUM => '每日还款额',
        self::TYPE_DAY_OVERDUE_SUM => '每日逾期额',
        self::TYPE_DAY_PASS_COUNT => '每日通过数',
    ];

    const MODE_HOURS = 'hours';
    const MODE_DAYS = 'days';

    public $type;//折线表
    public $date;//日期区间 [date1 - $date2]
    public $mode;//返回区间 hours days

    public $timeStart;
    public $timeEnd;

    public $dayRegisterSum = 0;
    public $dayOrderCount = 0;
    public $dayPassCount = 0;
    public $dayRemitCount = 0;
    public $dayRemitSum = 0;

    /**
     * WorkbenchLineServer constructor.
     */
    public function __construct()
    {
        $this->timeStart = DateHelper::date();
        $this->timeEnd = DateHelper::dateTime();
        $this->mode = self::MODE_HOURS;
    }

    /**
     * @param $param
     * @return mixed
     */
    public function getLine($param)
    {
        $this->type = array_get($param, 'type', self::TYPE_DAY_REGISTER_SUM);
        $this->date = array_get($param, 'date');
        if ($this->date && (count($this->date) == 2)) {
            $this->timeStart = current($this->date);
            $this->timeEnd = last($this->date);
            if ($this->timeStart != $this->timeEnd) {
                $this->mode = self::MODE_DAYS;
            }
            $this->timeEnd = DateHelper::endOfDay($this->timeEnd);
        }
        $cacheAllKey = 'statistics:workbench:line:all';
        $cacheKey = 'statistics:workbench:line:' . $this->type . '-' . $this->timeStart . '-' . $this->timeEnd;

        /** 设置总统计缓存 1分钟 */
        $tabs = Cache::remember($cacheAllKey, 1, function () {
            return $this->getTabs();
        });
        /** 设置条件统计缓存 1分钟 */
        $line = Cache::remember($cacheKey, 1, function () {
            call_user_func([$this, camel_case($this->type)]);
            return $this->data;
        });
        return [
            'tabs' => $tabs,
            'line' => $line,
        ];
    }

    /**
     * @return array
     */
    public function getTabs()
    {
        return [
            'day_register_sum' => $this->getAllSumByModel(new User(), 'created_at'),
            'day_order_count' => $this->getAllSumByModel(new Order(), 'created_at'),
            'day_pass_count' => $this->getAllSumByModel(new Order(), 'pass_time'),
            'day_remit_count' => $this->getAllSumByModel(new Order(), 'paid_time'),
            'day_remit_sum' => $this->getAllSumByModel(new Order(), 'paid_time', 'paid_amount', 'sum') . ' 元',
        ];
    }

    /**
     * 注册量
     */
    public function dayRegisterSum()
    {
        $sum = $this->getDataByModel(new User(), 'created_at');
        $this->data = $this->getLineByMode($sum);
    }

    /**
     * 订单量
     */
    public function dayOrderCount()
    {
        $sum = $this->getDataByModel(new Order(), 'created_at');
        $this->data = $this->getLineByMode($sum);
    }

    /**
     * 机审通过量
     */
    public function dayPassCount()
    {
        $sum = $this->getDataByModel(new Order(), 'pass_time');
        $this->data = $this->getLineByMode($sum);
    }

    /**
     * 放款数
     */
    public function dayRemitCount()
    {
        $sum = $this->getDataByModel(new Order(), 'paid_time');
        $this->data = $this->getLineByMode($sum);
    }

    /**
     * 放款金额
     */
    public function dayRemitSum()
    {
        $sum = $this->getDataByModel(new Order(), 'paid_time', 'paid_amount', 'sum');
        $this->data = $this->getLineByMode($sum);
    }

    /**
     * @param $model
     * @param $key
     * @param $val
     * @param string $operation
     * @return mixed
     */
    public function getDataByModel($model, $key, $val = '', $operation = 'count')
    {
        switch ($this->mode) {
            case self::MODE_HOURS:
                return $this->getHoursDataByModel($model, $key, $val, $operation);
            case self::MODE_DAYS:
                return $this->getDateDataByModel($model, $key, $val, $operation);
        }
    }

    /**
     * @param $model
     * @param $key
     * @param string $val
     * @param string $operation
     * @return mixed
     */
    public function getAllSumByModel($model, $key, $val = '', $operation = 'count')
    {
        if ($val == '') {
            $val = 1;
        }
        $count = $model
            ->select(DB::raw("{$operation}({$val}) as num"))
            ->where($key, '>', 0)
            ->first();
        return array_get($count, 'num', 0);
    }

    /**
     * @param $model
     * @param $key
     * @param $val
     * @param string $mode
     * @return mixed
     */
    public function getHoursDataByModel($model, $key, $val = '', $operation = 'count')
    {
        if ($val == '') {
            $val = 1;
        }
        if (!$this->data) {
            $groupHoursCount = $model
                ->select(DB::raw("left({$key}, 13) as date_hours, substring({$key}, 12, 2) as hours, {$operation}({$val}) as num"))
                ->whereBetween($key, [$this->timeStart, $this->timeEnd])
                ->groupBy('date_hours')
                ->pluck('num', 'hours');
            if ($operation == 'sum') {
                foreach ($groupHoursCount as $key => $data) {
                    $groupHoursCount[$key] = MoneyHelper::round2point($data);
                }
            }
            return $groupHoursCount;
        }
    }

    /**
     * @param $model
     * @param $key
     * @param $val
     * @param string $mode
     * @return mixed
     */
    public function getDateDataByModel($model, $key, $val = '', $operation = 'count')
    {
        if ($val == '') {
            $val = 1;
        }
        $groupDateCount = $model
            ->select(DB::raw("left({$key}, 10) as date, substring({$key}, 9, 2) as days, {$operation}({$val}) as num"))
            ->whereBetween($key, [$this->timeStart, $this->timeEnd])
            ->groupBy('date')
            ->pluck('num', 'date');
        if ($operation == 'sum') {
            foreach ($groupDateCount as $key => $data) {
                $groupDateCount[$key] = MoneyHelper::round2point($data);
            }
        }
        return $groupDateCount;
    }

    /**
     * @param $groupData1
     * @param $groupData2
     * @return array
     */
    public function getLineByMode($groupData1, $groupData2 = '')
    {
        switch ($this->mode) {
            case self::MODE_HOURS:
                return $this->getLineByHours($groupData1, $groupData2 = '');
            case self::MODE_DAYS:
                return $this->getLineByDate($groupData1, $groupData2 = '');
        }
    }

    /**
     * @param $groupHours1
     * @param $groupHours2
     * @return array
     */
    public function getLineByHours($groupHours1, $groupHours2 = '')
    {
        $data = [];
        $hoursArr = StatisticsHelper::hoursArr();
        foreach ($hoursArr as $hours) {
            $data[] = [
                'x' => strtotime($this->timeStart . ' ' . $hours . ':00:00'),
                'y' => array_get($groupHours1, $hours, 0),
            ];
        }
        return $data;
    }

    /**
     * @param $groupDate1
     * @param $groupDate2
     * @return array
     */
    public function getLineByDate($groupDate1, $groupDate2 = '')
    {
        $dateArr = StatisticsHelper::dateArr($this->timeStart, $this->timeEnd);
        foreach ($dateArr as $date) {
            $data[] = [
                'x' => strtotime($date),
                'y' => array_get($groupDate1, $date, 0),
            ];
        }
        return $data;
    }

    /**
     * 每日还款额
     */
    public function dayRepaySum()
    {
        $needRepayGroupHoursSum = $this->getDataByModel(new RepaymentPlan(), 'appointment_paid_time', 'principal', 'sum');
        $repayGroupHoursSum = $this->getDataByModel(new RepaymentPlan(), 'repay_time', 'repay_amount', 'sum');
        $this->data = $this->getLineByMode($needRepayGroupHoursSum, $repayGroupHoursSum);
    }

    /**
     * 每日逾期额
     */
    public function dayOverdueSum()
    {
        $overdueGroupHoursSum = $this->getDataByModel(
            Collection::model()->leftJoin('order', 'order.id', '=', 'collection.order_id'),
            'collection.created_at', DB::raw('order.principal+order.principal*order.daily_rate'), 'sum');
        $overdueRepayGroupHoursSum = $this->getDataByModel(
            Collection::model()->leftJoin('repayment_plan', 'repayment_plan.order_id', '=', 'collection.order_id')
                ->where('collection.status', Collection::STATUS_COLLECTION_SUCCESS),
            'collection.created_at', 'repayment_plan.repay_amount', 'sum');
        $this->data = $this->getLineByMode($overdueGroupHoursSum, $overdueRepayGroupHoursSum);
    }

}
