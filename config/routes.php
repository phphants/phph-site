<?php
/**
 * Expressive routed middleware
 */

/** @var \Zend\Expressive\Application $app */
$app->get('/', \App\Action\IndexAction::class, 'home');
$app->get('/meetups', \App\Action\MeetupsAction::class, 'meetups');
$app->get('/meetups.ics', \App\Action\MeetupsIcsAction::class, 'meetups-ics');
$app->get('/contact', \App\Action\ContactAction::class, 'contact');
$app->get('/sponsors', \App\Action\SponsorsAction::class, 'sponsors');
$app->get('/videos', \App\Action\VideosAction::class, 'videos');
$app->get('/code-of-conduct', \App\Action\CodeOfConductAction::class, 'code-of-conduct');
$app->get('/chat', \App\Action\ChatAction::class, 'chat');
$app->get('/chat/help', \App\Action\ChatHelpAction::class, 'chat-help');
$app->get('/team', \App\Action\TeamAction::class, 'team');
$app->get('/subscribe', \App\Action\SubscribeAction::class, 'subscribe');
$app->route('/account/login', \App\Action\Account\LoginAction::class, ['GET', 'POST'], 'account-login');
$app->route('/account/register', \App\Action\Account\RegisterAction::class, ['GET', 'POST'], 'account-register');
$app->get('/account/dashboard', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\DashboardAction::class,
], 'account-dashboard');
$app->get('/account/settings', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\SettingsAction::class,
], 'account-settings');
$app->route('/account/settings/change-password', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\Settings\ChangePassword::class,
], ['GET', 'POST'], 'account-settings-change-password');
$app->route('/account/settings/change-profile', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\Settings\ChangeProfileHandler::class,
], ['GET', 'POST'], 'account-settings-change-profile');
$app->route('/account/settings/delete-me', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\Settings\DeleteMeHandler::class,
], ['GET', 'POST'], 'account-settings-delete-me');
$app->get('/account/unlink-social/{loginId}', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\UnlinkThirdPartyAuthenticationAction::class,
], 'account-unlink-third-party-login');
$app->get('/account/meetups', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Meetup\ListMeetupsAction::class,
], 'account-meetups-list');
$app->route('/account/meetup/add', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Meetup\AddMeetupAction::class,
], ['GET', 'POST'], 'account-meetup-add');
$app->get('/account/meetup/{uuid}', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Meetup\ViewMeetupAction::class,
], 'account-meetup-view');
$app->route('/account/meetup/{uuid}/edit', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Meetup\EditMeetupAction::class,
], ['GET', 'POST'], 'account-meetup-edit');
$app->post('/account/meetup/{uuid}/toggle-attendance', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\Meetup\ToggleAttendanceAction::class,
], 'account-meetup-toggle-attendance');
$app->get('/account/meetup/{meetup}/check-in/{user}', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Meetup\CheckInUserAction::class,
], 'account-meetup-check-in-user');
$app->get('/account/meetup/{meetup}/cancel-check-in/{user}', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Meetup\CancelCheckInAction::class,
], 'account-meetup-cancel-check-in');
$app->get('/account/meetup/{meetup}/pick-a-winner', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Meetup\PickWinnerAction::class,
], 'account-meetup-pick-a-winner');
$app->get('/account/locations', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Location\ListLocationsAction::class,
], 'account-locations-list');
$app->route('/account/location/add', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Location\AddLocationAction::class,
], ['GET', 'POST'], 'account-location-add');
$app->route('/account/location/{uuid}/edit', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Location\EditLocationAction::class,
], ['GET', 'POST'], 'account-location-edit');
$app->get('/account/speakers', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Speaker\ListSpeakersAction::class,
], 'account-speakers-list');
$app->route('/account/speaker/add', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Speaker\AddSpeakerAction::class,
], ['GET', 'POST'], 'account-speaker-add');
$app->route('/account/speaker/{uuid}/edit', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Speaker\EditSpeakerAction::class,
], ['GET', 'POST'], 'account-speaker-edit');
$app->get('/account/logout', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware::class,
    \App\Action\Account\LogoutAction::class,
], 'account-logout');
$app->route('/account/meetup/{meetup}/add-talk', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Talk\AddTalkAction::class,
], ['GET', 'POST'], 'account-talk-add');
$app->route('/account/meetup/talk/{uuid}/edit', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Talk\EditTalkAction::class,
], ['GET', 'POST'], 'account-talk-edit');
$app->get('/account/meetup/talk/{uuid}/delete', [
    \App\Middleware\Authentication::class,
    \App\Service\Authorization\Middleware\HasAdministratorRoleMiddleware::class,
    \App\Action\Account\Talk\DeleteTalkAction::class,
], 'account-talk-delete');
$app->get('/account/twitter/authenticate', \App\Service\Twitter\AuthenticateAction::class, 'account-twitter-authenticate');
$app->get('/account/twitter/callback', \App\Service\Twitter\CallbackAction::class, 'account-twitter-callback');
$app->get('/account/github/authenticate', \App\Service\GitHub\AuthenticateAction::class, 'account-github-authenticate');
$app->get('/account/github/callback', \App\Service\GitHub\CallbackAction::class, 'account-github-callback');
