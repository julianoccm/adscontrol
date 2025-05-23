<?php
require_once __DIR__ . '/../persistence/database.php';

class AnnouncementService
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = DatabaseConnection::getInstance()->getPdo();
  }

  public function getAnnouncementById($announcementId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM announcements WHERE id = :id");
    $stmt->bindParam(':id', $announcementId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  public function getPendingAnnouncements()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM announcements WHERE status = 'PENDENTE'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getApprovedAnnouncements()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM announcements WHERE status = 'APROVADO'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAnnouncementsByUserId($userId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM announcements WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function setAnnouncementStatus($announcementId, $status)
  {
    $stmt = $this->pdo->prepare("UPDATE announcements SET status = :status WHERE id = :id");
    $stmt->bindParam(':id', $announcementId);
    $stmt->bindParam(':status', $status);
    return $stmt->execute();
  }

  public function approveAnnouncement($announcementId)
  {
    return $this->setAnnouncementStatus($announcementId, 'APROVADO');
  }

  public function rejectAnnouncement($announcementId)
  {
    return $this->setAnnouncementStatus($announcementId, 'PENDENTE');
  }

  public function deleteAnnouncement($announcementId)
  {
    $stmt = $this->pdo->prepare("DELETE FROM announcements WHERE id = :id");
    $stmt->bindParam(':id', $announcementId);
    return $stmt->execute();
  }

  public function createAnnouncement(Announcement $announcement)
  {
    /* Echo each field of the Announcement object */
    $title = $announcement->get_title();
    $description = $announcement->get_description();
    $target_gender = $announcement->get_target_gender();
    $target_age = $announcement->get_target_age();
    $image_url = $announcement->get_image_url();
    $status = $announcement->get_status();
    $user_id = $announcement->get_user_id();
    $created_at = $announcement->get_created_at();


    $stmt = $this->pdo->prepare(
      "INSERT INTO announcements 
        (title, description, target_gender, target_age, image_url, status, user_id) 
      VALUES 
        (:title, :description, :target_gender, :target_age, :image_url, :status, :user_id)"
    );

    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':target_gender', $target_gender);
    $stmt->bindParam(':target_age', $target_age);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':user_id', $user_id);

    return $stmt->execute();
  }

  public function updateAnnouncement(Announcement $announcement)
  {
    $id = $announcement->get_id();
    $title = $announcement->get_title();
    $description = $announcement->get_description();
    $target_gender = $announcement->get_target_gender();
    $target_age = $announcement->get_target_age();
    $status = $announcement->get_status();

    $stmt = $this->pdo->prepare(
      "UPDATE announcements SET 
        title = :title, 
        description = :description, 
        target_gender = :target_gender, 
        target_age = :target_age, 
        status = :status
      WHERE id = :id"
    );

    // Use PDO::PARAM_INT for bigint unsigned id
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':target_gender', $target_gender);
    $stmt->bindParam(':target_age', $target_age);
    $stmt->bindParam(':status', $status);

    return $stmt->execute();
  }
}