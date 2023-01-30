<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
// use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        // 'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterAdmin' => \App\Filters\FilterAdmin::class,
        'filterManager' => \App\Filters\FilterManager::class,
        'filterPurchasing' => \App\Filters\FilterPurchasing::class,
        'filterGudang' => \App\Filters\FilterGudang::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',

            'filterAdmin' => [
                'except' => ['login/*', 'login', '/']
            ],
            'filterManager' => [
                'except' => ['login/*', 'login', '/']
            ],
            'filterPurchasing' => [
                'except' => ['login/*', 'login', '/']
            ],
            'filterGudang' => [
                'except' => ['login/*', 'login', '/']
            ],
        ],
        'after' => [
            'filterAdmin' =>  ['except' => ['main/*', 'costumer/*', 'kategori/*', 'satuan/*', 'barang/*', 'barangmasuk/*', 'barangkeluar/*', 'po/*', 'users/*']],

            'filterManager' =>  ['except' => ['main/*', 'barang/*', 'barangmasuk/*', 'barangkeluar/*']],

            'filterPurchasing' =>  ['except' => ['main/*', 'kategori/*', 'satuan/*', 'barang/*', 'barangmasuk/*', 'barangkeluar/*']],

            'filterGudang' =>  ['except' => ['main/*', 'barangmasuk/*', 'barangkeluar/*']],

            // 'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}