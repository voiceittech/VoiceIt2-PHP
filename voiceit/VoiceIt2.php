<?php

namespace VoiceIt;
class VoiceIt2 {

  const VERSION = '3.7.0';
  public $baseUrl = '';
  public $notification_url = '';
  public $api_key;
  public $api_token;
  public $platformId = '42';

  function __construct($key, $token, $customUrl = 'https://api.voiceit.io') {
     $this->api_key = $key;
     $this->api_token = $token;
     $this->baseUrl = $customUrl;
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/phrases/'.$contentLanguage.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllUsers() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createUser() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function checkUserExists($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getGroupsForUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.'/groups'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteAllEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/'.$userId.'/all'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getAllVoiceEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/voice/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllFaceEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/face/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllVideoEnrollments($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/video/'.$userId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

	public function createVoiceEnrollment($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/voice'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/voice/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/face'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/face/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/video'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/video/byUrl'.$this->notification_url);
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

  public function getAllGroups() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getGroup($groupId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/'.$groupId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function groupExists($groupId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/'.$groupId.'/exists'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createGroup($description) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/addUser'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/removeUser'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/'.$groupId.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function voiceVerification($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/voice'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/voice/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/face'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/face/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/video'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/video/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/voice'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/voice/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/face'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/face/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/video'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/video/byUrl'.$this->notification_url);
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
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.'/token?timeOut='.strval($secondsToTimeout));
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function expireUserTokens($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.'/expireTokens');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function createUnmanagedSubAccount($firstName, $lastName, $email, $password, $contentLanguage) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/unmanaged'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
          'firstName' => $firstName,
          'lastName' => $lastName,
          'email' => $email,
          'password' => $password,
          'contentLanguage' => $contentLanguage
        ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function createManagedSubAccount($firstName, $lastName, $email, $password, $contentLanguage) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/managed'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
          'firstName' => $firstName,
          'lastName' => $lastName,
          'email' => $email,
          'password' => $password,
          'contentLanguage' => $contentLanguage
        ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function switchSubAccountType($firstName) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/'.$firstName.'/switchType'.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function regenerateSubAccountAPIToken($subAccountAPIKey) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/'.$subAccountAPIKey.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function deleteSubAccount($subAccountAPIKey) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/'.$subAccountAPIKey.$this->notification_url);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

}
?>
