<?php

namespace sd;

use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;

class Bitrix
{
    protected string $webhookURL = 'https://b24-lsw5uk.bitrix24.com/rest/1/3e1po351ezsoyx03/';
    protected Bitrix24API $bitrixInstance;

    public function __construct()
    {
        $this->bitrixInstance = new Bitrix24API($this->webhookURL);
    }

    public function addContacts(array $bitrixUsers)
    {
        try {
            $this->bitrixInstance->addContacts($bitrixUsers);
        } catch (Bitrix24APIException|\Exception $e) {
            echo "Error: {$e->getMessage()}";
            die();
        }
    }

    public function getUsers()
    {
        try {
            $users = $this->bitrixInstance->getContactList([], ['ID', 'EMAIL']);
            $users = $users->current();

            return $this->convertUsers($users);
        } catch (\Exception $e) {
            echo "Error: {$e->getMessage()}";
            die();
        }
    }

    protected function convertUsers(array $users): array
    {
        $convertedUsers = [];
        foreach ($users as $user) {
            $emails      = $user['EMAIL'];
            $emailsArray = [];

            if ( ! empty($emails) && is_array($emails)) {
                foreach ($emails as $email) {
                    $emailsArray[] = $email['VALUE'];
                }
            }
            $emailsString     = implode(',', $emailsArray);
            $convertedUsers[] = [
                'id'     => $user['ID'],
                'emails' => $emailsString,
            ];

        }

        return $convertedUsers;
    }
}
