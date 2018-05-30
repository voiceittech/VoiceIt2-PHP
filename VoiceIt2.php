<?php

class VoiceIt2 {

  public $BASE_URL = 'https://api.voiceit.io';
	public $api_key;
  public $api_token;

	function __construct($key, $token) {
				  $this->api_key = $key;
          $this->api_token = $token;
	}

  public function getAllUsers() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/users');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createUser() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/users');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function getUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/users/'.$userId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/users/'.$userId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getGroupsForUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/users/'.$userId.'/groups');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllEnrollmentsForUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/'.$userId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteAllEnrollmentsForUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/'.$userId.'/all');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getFaceFaceEnrollmentsForUser($userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/face/'.$userId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

	public function createVoiceEnrollment($userId, $contentLanguage, $filePath) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'recording' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createVoiceEnrollmentByUrl($userId, $contentLanguage, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/byUrl');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'fileUrl' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createFaceEnrollment($userId, $filePath, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/face');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createVideoEnrollment($userId, $contentLanguage, $filePath, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/video');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function createVideoEnrollmentByUrl($userId, $contentLanguage, $fileUrl, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/video/byUrl');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function deleteFaceEnrollment($userId, $faceEnrollmentId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/face/'.$userId.'/'.$faceEnrollmentId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function deleteEnrollmentForUser($userId, $enrollmentId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/enrollments/'.$userId.'/'.$enrollmentId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getAllGroups() {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/groups');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getGroup($groupId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/groups/'.$groupId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function groupExists($groupId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/groups/'.$groupId.'/exists');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createGroup($description) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/groups');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'description' => description
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
	}

  public function addUserToGroup($groupId, $userId) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/groups/addUser');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
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
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/groups/removeUser');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
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
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/groups/'.$groupId);
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function voiceVerification($userId, $contentLanguage, $filePath) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/verification');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'recording' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function voiceVerificationByUrl($userId, $contentLanguage, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/verification/byUrl');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'recording' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function faceVerification($userId, $filePath, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/verification/face');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoVerification($userId, $contentLanguage, $filePath, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/verification/video');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoVerificationByUrl($userId, $contentLanguage, $fileUrl, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/verification/video/byUrl');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function voiceIdentification($userId, $contentLanguage, $filePath) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/identification');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'recording' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function voiceIdentificationByUrl($userId, $contentLanguage, $fileUrl) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/identification/byUrl');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'recording' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoIdentification($userId, $contentLanguage, $filePath, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/identification/video');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => new CurlFile($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function videoIdentificationByUrl($userId, $contentLanguage, $fileUrl, $doBlinkDetection = true) {
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $this->BASE_URL.'/identification/video/byUrl');
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
      'userId' => $userId,
      'contentLanguage' => $contentLanguage,
      'doBlinkDetection' => $doBlinkDetection ? 1 : 0,
      'video' => $fileUrl
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

}
?>
