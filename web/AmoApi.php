<?php

class AmoApi
{
//    private $apiConf = array(
//        'USER_LOGIN' => 'sales@gk-sky.com', #Ваш логин (электронная почта)
//        'USER_HASH' => 'da549a03e026de8c0fdce3c681c92822' #Хэш для доступа к API (смотрите в профиле пользователя)
//    );
    private $apiConf = array(
        'USER_LOGIN' => 'vol@gk-sky.com', #Ваш логин (электронная почта)
        'USER_HASH' => '8d531d01ca4ac9e2b53c37736623ee000884ac4d' #Хэш для доступа к API (смотрите в профиле пользователя)
    );

    private $unsorted = array();

    public function addUnsortedToRemoteServer()
    {
        foreach ($this->unsorted as $item) {
            $link = 'https://gksky.amocrm.ru/api/unsorted/add/?api_key=' . $this->apiConf['USER_HASH'] . '&login=' . $this->apiConf['USER_LOGIN'];
            $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
            #Устанавливаем необходимые опции для сеанса cURL
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json']);
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($item));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

            $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $response = json_decode($out, true);
        }
        return $this;
    }

    public function setUnsortedExcursion($name, $phone, $tags, $source, $link, $from)
    {
        $data['request']['unsorted'] = array(
            'category' => 'forms',
            'add' => array(
                array(
                    'source' => $source,
                    'source_uid' => NULL,
                    'source_data' => array(
                        'data' =>
                            array(
                                'name_1' => array(
                                    'type' => 'text',
                                    'id' => 'name_1',
                                    'element_type' => '1',
                                    'name' => 'Имя',
                                    'value' => $name,
                                ),
                                '176171_1' => array(
                                    'type' => 'multitext',
                                    'id' => '176171_1',
                                    'element_type' => '1',
                                    'name' => 'Номер телефона',
                                    'value' =>
                                        array($phone),
                                ),
                                '393659_1' => array(
                                    'type' => 'terms',
                                    'id' => '393659_1',
                                    'element_type' => '1',
                                    'name' => 'Согласен на обработку персональных данных',
                                    'value' => 'on',
                                ),
                            ),
                        'form_id' => '195055',
                        'form_type' => '1',
                        'origin' => array(
                            'ip' => $this->getClientIp(),
                            'referer' => $link,
                        ),
                        'date' => time(),
                        'from' => $from,
                    ),
                    'data' => array(
                        'contacts' => array(
                            array(
                                'name' => $name,
                                'custom_fields' =>
                                    array(
                                        array(
                                            'id' => '176171',
                                            'values' =>
                                                array(
                                                    array(
                                                        'enum' => '383555',
                                                        'value' => $phone,
                                                    ),
                                                ),
                                        ),
                                        array(
                                            'id' => '393659',
                                            'values' =>
                                                array(
                                                    0 =>
                                                        array(
                                                            'value' => '1',
                                                        ),
                                                ),
                                        ),
                                    ),
                                'date_create' => time(),
                                'created_user_id' => '0',
                                'tags' => $tags,
                                'notes' =>
                                    array(
                                        array(
                                            'text' => '',
                                            'note_type' => '4',
                                            'element_type' => '1',
                                            'created_user_id' => '0',
                                        ),
                                    ),
                            ),
                        ),
                        'leads' =>
                            array(
                                array(
                                    'date_create' => time(),
                                    'created_user_id' => '0',
                                    'name' => $from,
                                    'tags' => $tags,
                                    'notes' =>
                                        array(
                                            array(
                                                'text' => '',
                                                'note_type' => '4',
                                                'element_type' => '2',
                                                'created_user_id' => '0',
                                            ),
                                        ),
                                ),
                            ),
                    ),
                )
            )

        );
        $this->unsorted[] = $data;
        return $this;
    }

    public function setUnsortedBuy($name, $phone, $comment, $tags, $source, $link, $from)
    {
        $data['request']['unsorted'] = array(
            'category' => 'forms',
            'add' => array(
                array(
                    'source' => $source,
                    'source_uid' => NULL,
                    'source_data' => array(
                        'data' => array(
                            'name_1' => array(
                                'type' => 'text',
                                'id' => 'name_1',
                                'element_type' => '1',
                                'name' => 'ФИО',
                                'value' => $name,
                            ),
                            '176171_1' => array(
                                'type' => 'multitext',
                                'id' => '176171_1',
                                'element_type' => '1',
                                'name' => 'Телефон',
                                'value' => array($phone),
                            ),
                            'note_2' => array(
                                'type' => 'text',
                                'id' => 'note_2',
                                'element_type' => '2',
                                'name' => 'Комментарий',
                                'value' => $comment,
                            ),
                            '393659_1' => array(
                                'type' => 'terms',
                                'id' => '393659_1',
                                'element_type' => '1',
                                'name' => 'Согласен на обработку персональных данных',
                                'value' => 'on',
                            ),
                        ),
                        'form_id' => '193012',
                        'form_type' => '1',
                        'origin' => array(
                            'ip' => $this->getClientIp(),
                            'referer' => $link,
                        ),
                        'date' => time(),
                        'from' => $from,
                    ),
                    'data' => array(
                        'contacts' => array(
                            array(
                                'name' => $name,
                                'custom_fields' => array(
                                    array(
                                        'id' => '176171',
                                        'values' => array(
                                            array(
                                                'enum' => '383555',
                                                'value' => $phone,
                                            ),
                                        ),
                                    ),
                                    array(
                                        'id' => '393659',
                                        'values' => array(array('value' => '1'))
                                    ),
                                ),
                                'date_create' => time(),
                                'created_user_id' => '0',
                                'tags' => $tags,
                                'notes' => array(
                                    array(
                                        'text' => '',
                                        'note_type' => '4',
                                        'element_type' => '1',
                                        'created_user_id' => '0',
                                    ),
                                ),
                            ),
                        ),
                        'leads' =>
                            array(
                                array(
                                    'date_create' => time(),
                                    'created_user_id' => '0',
                                    'name' => $from,
                                    'tags' => $tags,
                                    'notes' =>
                                        array(
                                            array(
                                                'text' => $comment,
                                                'note_type' => '4',
                                                'element_type' => '1',
                                                'created_user_id' => '0',
                                            ),
                                        ),
                                ),
                            ),
                    ),
                )
            )

        );
        $this->unsorted[] = $data;
        return $this;
    }

    // Function to get the client IP address
    private function getClientIp()
    {
        $ipAddress = 'UNKNOWN';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipAddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipAddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipAddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipAddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipAddress = getenv('REMOTE_ADDR');
        }
        return $ipAddress;
    }
}