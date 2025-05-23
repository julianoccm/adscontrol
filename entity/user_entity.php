<?php
class User
{
  public $id;
  public $email;
  public $password;
  public $cpf;
  public $role;
  public $created_at;

  public function __construct()
  {
  }

  public function getId()
  {
    return $this->id;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getCpf()
  {
    return $this->cpf;
  }

  public function getRole()
  {
    return $this->role;
  }

  public function getCreatedAt()
  {
    return $this->created_at;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function setCpf($cpf)
  {
    $this->cpf = $cpf;
  }

  public function setRole($role)
  {
    $this->role = $role;
  }

  public function setCreatedAt($created_at)
  {
    $this->created_at = $created_at;
  }

  public function isAdmin()
  {
    return $this->role === 'ADMIN';
  }

  public function toArray()
  {
    return [
      'id' => $this->id,
      'email' => $this->email,
      'password' => $this->password,
      'cpf' => $this->cpf,
      'created_at' => $this->created_at,
      'role' => $this->role
    ];
  }

  public function fromArray($data)
  {
    $this->id = $data['id'];
    $this->email = $data['email'];
    $this->password = $data['password'];
    $this->cpf = $data['cpf'];
    $this->created_at = $data['created_at'];
    $this->role = $data['role'];
  }
}