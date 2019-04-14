<?php


namespace App\Tasks;

use Phalcon\Cli\Task;

/**
 * Swoole 毫秒精度的定时器
 * https://wiki.swoole.com/wiki/page/p-timer.html
 * Class TimerTasks
 * @package App\Tasks
 */
class TimerTask extends Task
{
    /**
     * 设置一个间隔时钟定时器
     * @param array $params
     */
    public function tickAction(array $params = [])
    {
        //打印参数
        //var_dump($params);
        $timer_id = swoole_timer_tick(1000, function () {
            echo "每秒执行一次,10秒后停止！" . PHP_EOL;
        });

        swoole_timer_after(10000, function () use ($timer_id) {
            swoole_timer_clear($timer_id);
            echo "时间到了，结束！" . PHP_EOL;
        });

    }

    /**
     * 在指定的时间后执行函数
     */
    public function afterAction()
    {
        swoole_timer_after(2000, function () {
            echo "这是2s后执行的..." . PHP_EOL;
        });
    }
}