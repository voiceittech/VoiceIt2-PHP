<?php

namespace VoiceIt;
class VoiceIt2 {

  const BASE_URL = 'https://api.voiceit.io';
  const VERSION = '3.3.0';
  public $notification_url = '';
  public $api_key;
  public $api_token;
  public $platformId = '42';

  function __construct($key, $token) {
     $this->api_key = $key;
     $this->api_token = $token;
  }

  function checkFileExists($file) {
    if(!file_exists($file)){
      throw new \Exception("File {$file} does not exist");
    }
  }

  public function getVersion() {
     return VoiceIt2::VERSION;
  }

  public function addNotificationUrl($url) {
     $this->notification_url = '?notificationURL='.urlencode($url);
  }

  public function removeNotificationUrl() {
     $this->notification_url = '';
  }

  public function getNotificationUrl() {
     return $this->notification_url;
  }

  public function getPhrases($contentLanguage) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/phrases/'.$contentLanguage.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllUsers() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/users'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createUser() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/users'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function checkUserExists($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/users/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/users/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getGroupsForUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/users/'.$userId.'/groups'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteAllEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/'.$userId.'/all'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getAllVoiceEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/voice/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllFaceEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/face/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllVideoEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/video/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

	public function createVoiceEnrollment($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/voice'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'recording' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createVoiceEnrollmentByUrl($userId, $contentLanguage, $phrase, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/voice/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createFaceEnrollment($userId, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/face'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createFaceEnrollmentByUrl($userId, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/face/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createVideoEnrollment($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/video'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createVideoEnrollmentByUrl($userId, $contentLanguage, $phrase, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/video/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function deleteAllVoiceEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/'.$userId.'/voice'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function deleteAllFaceEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/'.$userId.'/face'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function deleteAllVideoEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/'.$userId.'/video'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function deleteVoiceEnrollment($userId, $enrollmentId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/voice/'.$userId.'/'.strval($enrollmentId).$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function deleteFaceEnrollment($userId, $faceEnrollmentId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/face/'.$userId.'/'.strval($faceEnrollmentId).$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function deleteVideoEnrollment($userId, $enrollmentId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/enrollments/video/'.$userId.'/'.strval($enrollmentId).$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getAllGroups() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/groups'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getGroup($groupId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/groups/'.$groupId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function groupExists($groupId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/groups/'.$groupId.'/exists'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createGroup($description) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/groups'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'description' => $description
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function addUserToGroup($groupId, $userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/groups/addUser'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'PUT');
    $fields = [
      'groupId' => $groupId,
      'userId' => $userId
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function removeUserFromGroup($groupId, $userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/groups/removeUser'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'PUT');
    $fields = [
      'groupId' => $groupId,
      'userId' => $userId
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function deleteGroup($groupId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/groups/'.$groupId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function voiceVerification($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/verification/voice'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'recording' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function voiceVerificationByUrl($userId, $contentLanguage, $phrase, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/verification/voice/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function faceVerification($userId, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/verification/face'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function faceVerificationByUrl($userId, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/verification/face/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoVerification($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/verification/video'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoVerificationByUrl($userId, $contentLanguage, $phrase, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/verification/video/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function voiceIdentification($groupId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/identification/voice'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'groupId' => $groupId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'recording' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function voiceIdentificationByUrl($groupId, $contentLanguage, $phrase, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/identification/voice/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'groupId' => $groupId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function faceIdentification($groupId, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/identification/face'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'groupId' => $groupId,
      'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function faceIdentificationByUrl($groupId, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/identification/face/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'groupId' => $groupId,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoIdentification($groupId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/identification/video'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'groupId' => $groupId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoIdentificationByUrl($groupId, $contentLanguage, $phrase, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/identification/video/byUrl'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'groupId' => $groupId,
      'contentLanguage' => $contentLanguage,
      'phrase' => $phrase,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }


  public function createUserToken($userId, $secondsToTimeout) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/users/'.$userId.'/token?timeOut='.strval($secondsToTimeout));
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function expireUserTokens($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, VoiceIt2::BASE_URL.'/users/'.$userId.'/expireTokens');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

}
?>
