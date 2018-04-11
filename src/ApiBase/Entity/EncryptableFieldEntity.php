<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 14:02:18
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 13:43:51
 */

namespace ApiBase\Entity;

class EncryptableFieldEntity
{
    protected $hashOptions = ['cost' => 11];

    protected function encryptField($value)
    {
        return password_hash(
            $value,
            PASSWORD_BCRYPT,
            $this->hashOptions
        );
    }

    protected function verifyEncryptedFieldValue($encryptedValue, $value)
    {
        return password_verify($value, $encryptedValue);
    }
}
