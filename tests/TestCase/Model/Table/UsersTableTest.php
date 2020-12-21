<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.Groups',
        'app.Affiliations',
        'app.Roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

        parent::tearDown();
    }

    public function testAddUserAndCounterCache()
    {
        $group = $this->Users->Groups->newEntity();
        $group = $this->Users->Groups->saveOrFail($group);

        $user = $this->Users->newEntity(['group_id' => $group->id]);
        $user = $this->Users->saveOrFail($user);

        $this->assertNotEmpty($user->id);
        $group = $this->Users->Groups->get($user->group_id);
        $this->assertEquals(1, $group->users_count);
    }

    public function testAffiliateAndCounterCache()
    {
        $group = $this->Users->Groups->newEntity();
        $group = $this->Users->Groups->saveOrFail($group);
        $user = $this->Users->newEntity(['group_id' => $group->id]);
        $user = $this->Users->saveOrFail($user);
        $role = $this->Users->Roles->newEntity();
        $role = $this->Users->Roles->saveOrFail($role);

        $linked = $this->Users->Roles->link($user, [$role]);

        $this->assertTrue($linked);

        $user = $this->Users->get($user->id);
        $role = $this->Users->Roles->get($role->id);

        $this->assertEquals(1, $user->roles_count);
        $this->assertEquals(1, $role->users_count);
    }
}
