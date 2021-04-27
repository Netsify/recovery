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
}