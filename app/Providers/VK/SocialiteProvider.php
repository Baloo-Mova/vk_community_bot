<?php

namespace App\Providers\VK;

use App\Core\VK;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use SocialiteProviders\Manager\OAuth2\User;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\InvalidStateException;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class SocialiteProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'VK';
    protected $fields = ['uid', 'first_name', 'last_name', 'screen_name', 'photo_200'];
    /**
     * {@inheritdoc}
     */
    protected $scopes = [
        'info',
        'offline',
        'groups',
        'stats',
        'email'
    ];

    /**
     * {@inheritdoc}
     */
    public static function additionalConfigKeys()
    {
        return ['lang'];
    }

    public function authUser()
    {
        $user   = $this->user();
        $dbUser = \App\Models\User::where('vk_id', '=', $user->id)->first();
        if ( ! isset($dbUser)) {
            $dbUser            = new \App\Models\User();
            $dbUser->name      = $user->nickname;
            $dbUser->email     = $user->email;
            $dbUser->password  = Hash::make(uniqid());
            $dbUser->vk_token  = $user->token;
            $dbUser->vk_id     = $user->id;
            $dbUser->expiresIn = $user->expiresIn;
            $dbUser->avatar    = $user->avatar;
            $dbUser->FIO       = $user->name;
            $dbUser->save();
        } else {
            $dbUser->name      = $user->nickname;
            $dbUser->email     = $user->email;
            $dbUser->vk_token  = $user->token;
            $dbUser->vk_id     = $user->id;
            $dbUser->expiresIn = $user->expiresIn;
            $dbUser->avatar    = $user->avatar;
            $dbUser->FIO       = $user->name;
            $dbUser->save();
        }

        $vk = new VK();
        $vk->setUser($dbUser);
        $vk->updateUserGroups();

        return $dbUser;
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException();
        }

        $user = $this->mapUserToObject($this->getUserByToken($token = $this->getAccessTokenResponse($this->getCode())));
        $exp  = array_get($token, 'expires_in') == 0 ? 86400 : array_get($token, 'expires_in');

        return $user->setToken(array_get($token, 'access_token'))->setExpiresIn(time() + $exp);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => array_get($user, 'uid'),
            'nickname' => array_get($user, 'screen_name'),
            'name'     => trim(array_get($user, 'first_name') . ' ' . array_get($user, 'last_name')),
            'email'    => array_get($user, 'email'),
            'avatar'   => array_get($user, 'photo_200'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $lang     = $this->getConfig('lang');
        $lang     = $lang ? '&lang=' . $lang : '';
        $response = $this->getHttpClient()->get('https://api.vk.com/method/users.get?user_ids=' . $token['user_id'] . '&fields=' . implode(',',
                $this->fields) . $lang . '&https=1');

        $response = json_decode($response->getBody()->getContents(), true)['response'][0];

        return array_merge($response, [
            'email' => array_get($token, 'email'),
        ]);
    }

    /**
     * Get a instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {

        if (is_null($this->httpClient)) {
            $this->httpClient = new Client([
                'proxy'  => '194.28.208.59:8000',
                'verify' => false,
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Set the user fields to request from Vkontakte.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://oauth.vk.com/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://oauth.vk.com/access_token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function parseAccessToken($body)
    {
        return json_decode($body, true);
    }
}
