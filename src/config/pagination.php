<?php

return [
    // 默认分页配置
    'default' => [
        'currentPage'    => [
            'source' => 'query_string',
            'key'    => 'page'
        ],
        // source: "query_string"或"route"
        'totalItems'     => 0,
        'itemsPerPage'   => 10,
        'view'           => 'sdk/pagination/basic',
        'autoHide'       => true,
        'firstPageInUrl' => true,
    ],
];

