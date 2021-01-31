<?php namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
  protected $table = 'users';
  protected $returnType = 'object';
  protected $useTimestamps = true;
  protected $allowedFields = ['name', 'address', 'photo'];

  public function getUser($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }

    return $this->where(['id' => $id])->first();
  }

  public function getLastName($id){
    return $this->select('name')->where(['id' => $id])->first();
  }

  public function search($keyword)
  {
    return $this->table('users')->like('name', $keyword)->orLike('address', $keyword);
  }
}