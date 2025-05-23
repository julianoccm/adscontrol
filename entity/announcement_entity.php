<?php
class Announcement
{
  public $id;
  public $title;
  public $description;
  public $target_gender;
  public $target_age;
  public $image_url;
  public $status;
  public $user_id;
  public $created_at;

  public function __construct()
  {
  }

  public function get_id()
  {
    return $this->id;
  }
  public function get_title()
  {
    return $this->title;
  }
  public function get_description()
  {
    return $this->description;
  }
  public function get_target_gender()
  {
    return $this->target_gender;
  }
  public function get_target_age()
  {
    return $this->target_age;
  }
  public function get_image_url()
  {
    return $this->image_url;
  }
  public function get_status()
  {
    return $this->status;
  }
  public function get_user_id()
  {
    return $this->user_id;
  }
  public function get_created_at()
  {
    return $this->created_at;
  }
  public function set_user_id($user_id)
  {
    $this->user_id = $user_id;
  }
  public function set_status($status)
  {
    $this->status = $status;
  }
  public function set_created_at($created_at)
  {
    $this->created_at = $created_at;
  }
  public function set_id($id)
  {
    $this->id = $id;
  }
  public function set_title($title)
  {
    $this->title = $title;
  }
  public function set_description($description)
  {
    $this->description = $description;
  }
  public function set_target_gender($target_gender)
  {
    $this->target_gender = $target_gender;
  }
  public function set_target_age($target_age)
  {
    $this->target_age = $target_age;
  }
  public function set_image_url($image_url)
  {
    $this->image_url = $image_url;
  }
  public function to_array()
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'target_gender' => $this->target_gender,
      'target_age' => $this->target_age,
      'image_url' => $this->image_url,
      'status' => $this->status,
      'user_id' => $this->user_id,
      'created_at' => $this->created_at
    ];
  }

  public function fromArray($data)
  {
    $this->id = $data['id'];
    $this->title = $data['title'];
    $this->description = $data['description'];
    $this->target_gender = $data['target_gender'];
    $this->target_age = $data['target_age'];
    $this->image_url = $data['image_url'];
    $this->status = $data['status'];
    $this->user_id = $data['user_id'];
    $this->created_at = $data['created_at'];
  }
}