<?php
require_once __DIR__ . '/../persistence/database.php';

class UserService
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = DatabaseConnection::getInstance()->getPdo();
  }

  public function getUserById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getUserByEmail($email)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function createUser($user)
  {
    $email = $user->getEmail();
    $password = $user->getPassword();

    $cpf = $user->getCpf();
    $role = $user->getRole();

    $stmt = $this->pdo->prepare("INSERT INTO users (email, password, cpf, role) VALUES (:email, :password, :cpf, :role)");
    $stmt->bindParam(':email', $email);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashedPassword);

    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':role', $role);
    return $stmt->execute();
  }

  public function hashPassword(User $user)
  {
    $user->password = password_hash($user->password, PASSWORD_DEFAULT);
  }

  public function verifyPassword(User $user, $password)
  {
    return password_verify($password, $user->password);
  }
}