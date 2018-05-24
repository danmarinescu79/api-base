<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-04-11 14:17:05
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-05-24 14:10:34
 */

namespace ApiBase\Form\Fieldset;

use ApiBase\Entity\OAuthUser as Entity;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineModule\Validator\UniqueObject;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator;

class OAuthUser extends Fieldset implements InputFilterProviderInterface
{
    private $objectManager;
    private $allowEmpty;

    public function __construct(ObjectManager $objectManager, bool $allowEmpty = false)
    {
        parent::__construct('oauth_user');

        $this->objectManager = $objectManager;
        $this->allowEmpty    = $allowEmpty;

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Entity());

        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'id',
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'first_name',
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'last_name',
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'email',
        ]);

        $this->add([
            'type' => Element\Password::class,
            'name' => 'password',
        ]);

        $this->add([
            'type' => Element\Password::class,
            'name' => 'verify_password',
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required' => false,
            ],
            'first_name' => [
                'required' => true,
            ],
            'last_name' => [
                'required' => true,
            ],
            'email' => [
                'required'   => true,
                'validators' => [
                    [
                        'name'    => UniqueObject::class,
                        'options' => [
                            'object_repository' => $this->objectManager->getRepository(Entity::class),
                            'object_manager'    => $this->objectManager,
                            'fields'            => 'email',
                            'use_context'       => true,
                            'messages'          => [
                                'objectNotUnique' => 'A user with this email already exists.',
                            ],
                        ],
                    ],
                ],
            ],
            'password' => [
                'required'    => $this->allowEmpty ? false : true,
                'allow_empty' => $this->allowEmpty,
                'validators'  => [
                    [
                        'name'    => Validator\StringLength::class,
                        'options' => [
                            'min' => 6,
                            'max' => 18,
                        ],
                    ],
                ],
            ],
            'verify_password' => [
                'required'    => $this->allowEmpty ? false : true,
                'allow_empty' => $this->allowEmpty,
                'validators'  => [
                    [
                        'name'    => Validator\Identical::class,
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
            ],
        ];
    }
}
