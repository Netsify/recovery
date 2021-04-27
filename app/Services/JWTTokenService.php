<?php

namespace App\Services;


use ReallySimpleJWT\Token;

class JWTTokenService
{
    const NAME   = 'kineu';

    const SECRET = 'KInEU2020@kv';

    public $user_id;

    public $name;

    public $timeopen;

    public $timeclose;

    public $duration;

    public $url;

    public $submit_url;

    public $lang;

    /**
     * Правила для прокторинга
     *
     * @var array
     */
    protected $rules;

    protected $cheating_code;

    private $token;

    public function __construct($token = null)
    {
        $this->token = $token;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function setCheatingCode($cheating_code)
    {
        $this->cheating_code = $cheating_code;
    }

    public function make()
    {
        $data = [
            'user_id'       => $this->user_id,
            'name'          => $this->name,
            'timeopen'      => $this->timeopen,
            'timeclose'     => $this->timeclose,
            'duration'      => $this->duration,
            'rules'         => $this->rules,
            'cheating_code' => $this->cheating_code,
            'url'           => $this->url,
            'submit_url'    => $this->submit_url
        ];

        return Token::customPayload($data, self::SECRET);
    }

    /**
     * Возвращает payload из токена
     *
     * @return array
     * @throws \Exception
     */
    public function decode()
    {
        if (!$this->token) {
            throw new \Exception("Invalid token");
        }

        return Token::getPayload($this->token, self::SECRET);
    }
}