<?php

// ── Autoload & bootstrap ──────────────────────────────────────
define('BASE_PATH', is_dir(__DIR__ . '/app') ? __DIR__ : dirname(__DIR__));
// Taruh setelah define BASE_PATH
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/core/Router.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Controller.php';

function url(string $path = ''): string {
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    $path = ltrim($path, '/');
    return $path ? "$base/$path" : "$base/";
}

Session::start();

// ── Router ────────────────────────────────────────────────────
$router = new Router();

// --- Halaman publik ---
$router->get('/',                    'HomeController',      'index');

// --- Auth ---
$router->get('/login',               'AuthController',      'loginForm');
$router->post('/login',              'AuthController',      'login');
$router->get('/register',            'AuthController',      'registerForm');
$router->post('/register',           'AuthController',      'register');
$router->get('/logout',              'AuthController',      'logout');

// --- World Map ---
$router->get('/worldmap',            'WorldMapController',  'index');

// --- Chapter ---
$router->get('/chapter/:slug',       'ChapterController',   'show');

// --- Track / Song Sanctuary ---
$router->get('/track/:id',           'TrackController',     'show');

// --- Quest ---
$router->post('/quest/submit',       'QuestController',     'submit');
$router->get('/quest/next/:id',      'QuestController',     'next');

// --- Guestbook / Final Stage ---
$router->get('/final/:slug',         'GuestbookController', 'show');
$router->post('/final/:slug',        'GuestbookController', 'store');

// Dashboard
$router->get('/admin',                        'AdminController',         'dashboard');

// Chapters
$router->get('/admin/chapters',               'AdminChapterController',  'index');
$router->get('/admin/chapters/create',        'AdminChapterController',  'create');
$router->post('/admin/chapters/store',        'AdminChapterController',  'store');
$router->get('/admin/chapters/:id/edit',      'AdminChapterController',  'edit');
$router->post('/admin/chapters/:id/update',   'AdminChapterController',  'update');
$router->post('/admin/chapters/:id/delete',   'AdminChapterController',  'delete');
$router->post('/admin/chapters/:id/toggle',   'AdminChapterController',  'toggle');

// Tracks
$router->get('/admin/chapters/:id/tracks',           'AdminTrackController', 'index');
$router->get('/admin/chapters/:id/tracks/create',    'AdminTrackController', 'create');
$router->post('/admin/chapters/:id/tracks/store',    'AdminTrackController', 'store');
$router->get('/admin/tracks/:id/edit',               'AdminTrackController', 'edit');
$router->post('/admin/tracks/:id/update',            'AdminTrackController', 'update');
$router->post('/admin/tracks/:id/delete',            'AdminTrackController', 'delete');

// Quests
$router->get('/admin/tracks/:id/quest',              'AdminQuestController', 'show');
$router->post('/admin/tracks/:id/quest/store',       'AdminQuestController', 'store');
$router->post('/admin/quests/:id/update',            'AdminQuestController', 'update');
$router->post('/admin/quests/:id/delete',            'AdminQuestController', 'delete');

// Milestones
$router->get('/admin/chapters/:id/milestones',       'AdminMilestoneController', 'index');
$router->post('/admin/chapters/:id/milestones/store','AdminMilestoneController', 'store');
$router->post('/admin/milestones/:id/update',        'AdminMilestoneController', 'update');
$router->post('/admin/milestones/:id/delete',        'AdminMilestoneController', 'delete');

// Users
$router->get('/admin/users',                  'AdminUserController',     'index');
$router->post('/admin/users/:id/role',        'AdminUserController',     'updateRole');
$router->post('/admin/users/:id/delete',      'AdminUserController',     'delete');

// Guestbook
$router->get('/admin/guestbook',              'AdminGuestbookController','index');
$router->post('/admin/guestbook/:id/delete',  'AdminGuestbookController','delete');

// ── Dispatch ─────────────────────────────────────────────────
$router->dispatch();

