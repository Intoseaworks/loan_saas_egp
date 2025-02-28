<?php

use Laravel\Lumen\Routing\Router;

/**
 * 催收员每日统计
 *
 * @var Router $router
 */

$router->group([
    'namespace' => 'Admin\Controllers\CollectionStatistics',
    'path' => 'statistics.urgeRegain-statistics.urgeregainefficiency',
], function (Router $router) {
    //催收员每日统计列表
    $router->get('collection-statistics/efficiency-list', 'CollectionStatisticsController@efficiencyList');
});
