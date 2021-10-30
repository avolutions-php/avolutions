<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace {
    use PHPUnit\Framework\TestCase;

    use Application\Model\User;

    class EntityTest extends TestCase
    {
        /**
         * @var User
         */
        private $Entity;

        protected function setUp(): void
        {
            // Create a new entity
            $this->Entity = new User([
                'id' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'hobbies' => 'Blogging',
                'genderID' => 1,
                'Gender' => [
                    'id' => 1,
                    'label' => 'male',
                ],
            ]);
        }
    
        public function testConvertEntityToArray()
        {
            // Convert entity to array
            $array = $this->Entity->toArray();

            $this->assertEquals([
                'id' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'hobbies' => 'Blogging',
                'genderID' => 1,
            ], $array);

            // Update entity properties
            $this->Entity->hobbies = 'Blogging, Video Games';

            $array = $this->Entity->toArray();
            $this->assertEquals([
                'id' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'hobbies' => 'Blogging, Video Games',
                'genderID' => 1,
            ], $array);
        }

        public function testConvertEntityIncludingEntityTypeProperties()
        {
            // Convert entity to array
            $array = $this->Entity->toArray(true);

            $this->assertEquals([
                'id' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'hobbies' => 'Blogging',
                'genderID' => 1,
                'Gender' => [
                    'id' => 1,
                    'label' => 'male',
                ],
            ], $array);

            // Update entity properties
            $this->Entity->hobbies = 'Blogging, Video Games';

            $array = $this->Entity->toArray(true);
            $this->assertEquals([
                'id' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'hobbies' => 'Blogging, Video Games',
                'genderID' => 1,
                'Gender' => [
                    'id' => 1,
                    'label' => 'male',
                ],
            ], $array);
        }
    }
}

namespace Application\Model {
    use Avolutions\Orm\Entity;

    class User extends Entity
    {
    }

    class Gender extends Entity
    {
    }
}
