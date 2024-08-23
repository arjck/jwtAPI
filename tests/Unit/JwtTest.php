<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class JwtTest extends TestCase
{
    protected $host = '127.0.0.1:8002';
    protected $registerUrl = '/api/register';
    protected $loginUrl = '/api/login';
    protected $userUrl = '/api/user';
    protected $logoutUrl = '/api/logout';

    /**
     * Register: 127.0.0.1:8002/api/register?name=abc&email=123@abc.com&password=password
     *
     * @return void
     */
    public function test_Register(): void
    {
        $data = array(
            'name'  => 'abc',
            'email' => '123@abc.com',
            'password' => 'password'
        );
        $json = $this->getJson(
            $data,
            "{$this->host}{$this->registerUrl}"
        );
        $expected = '{"email":["The email has already been taken."]}';

        $this->assertSame($expected, $json);
    }

    /**
     * Login: 127.0.0.1:8002/api/login?email=123@abc.com&password=password
     *
     * @return void
     */
    public function test_Login(): void
    {
        $data = array(
            'email' => '123@abc.com',
            'password' => 'password'
        );
        $json = $this->getJson(
            $data,
            "{$this->host}{$this->loginUrl}"
        );

        $this->assertNotEmpty($json);
    }

    /**
     * Logout: 127.0.0.1:8002/api/logout
     *
     * @return void
     */
    public function test_Logout(): void
    {
        $json = $this->getJson(
            null,
            "{$this->host}{$this->logoutUrl}"
        );
        $expected = '{"status":"success","message":"Successfully logged out"}';
        $this->assertSame($expected, $json);
    }

    /**
     * Helper function for curl requests
     *
     * @param array|null $data
     * @param string $url
     * @return string
     */
    private function getJson(?array $data, string $url): string {
        $ch = curl_init($url);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array('Content-Type:application/json')
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
             CURLOPT_POSTFIELDS,
             json_encode($data, JSON_UNESCAPED_UNICODE)
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
