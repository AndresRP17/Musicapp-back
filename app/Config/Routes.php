<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {

    $routes->post('login', 'User\UserLoginController::login');
    $routes->patch('users/(:num)', 'User\UserPatchController::patch/$1');

    //MOVEMENTS
    $routes->get('movements', 'Movement\MovementsGetController::search');
    $routes->get('movements/(:num)', 'Movement\MovementGetController::find/$1');
    $routes->post('movements', 'Movement\MovementPostController::create');
    $routes->put('movements/(:num)', 'Movement\MovementPutController::put/$1');
    $routes->delete('movements/(:num)', 'Movement\MovementDeleteController::do/$1');

    //TEACHERS
    $routes->get('teachers', 'Teacher\TeachersGetController::search');
    $routes->get('teachers/(:num)', 'Teacher\TeacherGetController::find/$1');
    $routes->post('teachers', 'Teacher\TeacherPostController::create');
    $routes->put('teachers/(:num)', 'Teacher\TeacherPutController::put/$1');
    $routes->delete('teachers/(:num)', 'Teacher\TeacherDeleteController::do/$1');

    //USERS
    $routes->get('users', 'User\UsersGetController::search');
    $routes->get('users/(:num)', 'User\UserGetController::find/$1');
    $routes->post('users', 'User\UserPostController::create');
    $routes->put('users/(:num)', 'User\UserPutController::put/$1');
    $routes->delete('users/(:num)', 'User\UserDeleteController::do/$1', ['filter' => 'auth']);

    //FAVORITES
    $routes->post('favorites', 'Favorite\FavoritePostController::create');
    $routes->get('favorites', 'Favorite\FavoritesGetController::search');
    $routes->get('favorites/(:num)', 'Favorite\FavoriteGetController::find/$1');
    $routes->delete('favorites/(:num)', 'Favorite\FavoriteDeleteController::do/$1,');
    $routes->post('favorites', 'Favorite\FavoritePostController::create');

    //MUSICUSERS
    $routes->post('music_users', 'MusicUser\MusicUserPostController::create');
    $routes->get('music_users/(:num)', 'MusicUser\MusicUserGetController::find/$1');
    $routes->get('music_users', 'MusicUser\MusicUsersGetController::search');
    $routes->delete('music_users/(:num)', 'MusicUser\MusicUserDeleteController::do/$1');
    $routes->put('music_users/(:num)', 'MusicUser\MusicUserPutController::put/$1');
    $routes->patch('music_users/(:num)', 'MusicUser\MusicUserPatchController::patch/$1');
    $routes->post('music_users/login', 'MusicUser\MusicUserLoginController::login');
    $routes->post('music_users/logo', 'MusicUser\MusicUserPutController::uploadLogo');
    $routes->get('music_users/(:num)/projection', 'MusicUser\MusicUserProjectionController::find/$1');
    $routes->post('music_users/role', 'MusicUser\MusicUserPutController::updateRole');
    $routes->post('music_users/google', 'MusicUser\MusicUserGoogleLoginController::login');
    $routes->post('music_users/password', 'MusicUser\MusicUserChangePasswordController::change');
    $routes->post('music_users/forgot-password', 'MusicUser\MusicUserForgotPasswordController::forgot');
   $routes->post('music_users/reset-password', 'MusicUser\MusicUserResetPasswordController::reset');

   
    //PLAYLIST
    $routes->post('playlists', 'Playlist\PlaylistPostController::create');
    $routes->get('playlists/(:num)', 'Playlist\PlaylistGetController::find/$1');
    $routes->get('playlists', 'Playlist\PlaylistsGetController::search');
    $routes->delete('playlists/(:num)', 'Playlist\PlaylistDeleteController::do/$1');

    //PLAYLISTSONGS
    $routes->post('playlist_songs', 'PlaylistSongs\PlaylistSongsPostController::create');
    $routes->get('playlist_songs/playlist/(:num)', 'PlaylistSongs\PlaylistsSongsGetController::search/$1');
    $routes->get('playlist_songs', 'PlaylistSongs\PlaylistsSongsGetController::search');
    $routes->delete('playlist_songs/(:num)', 'PlaylistSongs\PlaylistSongsDeleteController::do/$1');

    //PAGOS
    $routes->post('pagos', 'Pagos\PagosPostController::create');
    $routes->get('pagos/(:num)', 'Pagos\PagoGetController::find/$1');
    $routes->get('pagos', 'Pagos\PagosGetController::search/$1');
    $routes->delete('pagos/(:num)', 'Pagos\PagoDeleteController::do/$1');

    //ALBUM
    $routes->get('albums', 'Album\AlbumGetController::obtener');
    $routes->get('lyrics', 'Lyric\LyricGetController::obtener');
    $routes->get('albums/genero', 'Album\AlbumGetController::buscarPorGenero');
    $routes->put('tracks/offset', 'Track\TrackOffsetPutController::actualizar');
    $routes->post('historial', 'Historial\HistorialPostController::create');
    $routes->get('stats', 'Historial\StatsGetController::obtener');
});