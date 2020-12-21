<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Affiliation Entity
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $role_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Role $role
 */
class Affiliation extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'role_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'role' => true,
    ];
}
