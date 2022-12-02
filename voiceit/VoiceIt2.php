<?php

namespace VoiceIt;
class VoiceIt2 {

  const VERSION = '3.7.1';
  public $baseUrl;
  public $notificationUrl = '';
  public $apiKey;
  public $apiToken;
  public $platformId = '42';

  function __construct($key, $token, $customUrl = 'https://api.voiceit.io') {
    $this->apiKey = $key;
    $this->apiToken = $token;
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
    $this->notificationUrl = '?notificationURL='.urlencode($url);
  }

  public function removeNotificationUrl() {
    $this->notificationUrl = '';
  }

  public function getNotificationUrl() {
    return $this->notificationUrl;
  }

  protected function createHandler(){
    $crl = curl_init();

    $this->setDefaultOptions($crl);

    return $crl;
  }

  protected function setDefaultOptions(&$crl){
    curl_setopt($crl, CURLOPT_USERPWD, "$this->api_key:$this->api_token");
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('platformId: '.$this->platformId, 'platformVersion: '.VoiceIt2::VERSION));
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
  }

  public function getPhrases($contentLanguage) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/phrases/'.$contentLanguage.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllUsers() {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createUser() {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function checkUserExists($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteUser($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getGroupsForUser($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.'/groups'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function deleteAllEnrollments($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/'.$userId.'/all'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function getAllVoiceEnrollments($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/voice/'.$userId.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllFaceEnrollments($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/face/'.$userId.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getAllVideoEnrollments($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/video/'.$userId.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createVoiceEnrollment($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/voice'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/voice/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/face'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
        'userId' => $userId,
        'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function createFaceEnrollmentByUrl($userId, $fileUrl) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/face/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/video'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/enrollments/video/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function getGroup($groupId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/'.$groupId.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function groupExists($groupId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/'.$groupId.'/exists'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'GET');
    return curl_exec($crl);
  }

  public function createGroup($description) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
        'description' => $description
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function addUserToGroup($groupId, $userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/addUser'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'PUT');
    $fields = [
        'groupId' => $groupId,
        'userId' => $userId
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function removeUserFromGroup($groupId, $userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/removeUser'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'PUT');
    $fields = [
        'groupId' => $groupId,
        'userId' => $userId
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function deleteGroup($groupId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/groups/'.$groupId.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

  public function voiceVerification($userId, $contentLanguage, $phrase, $filePath) {
    $this->checkFileExists($filePath);
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/voice'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/voice/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/face'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
        'userId' => $userId,
        'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function faceVerificationByUrl($userId, $fileUrl) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/face/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/video'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/verification/video/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/voice'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/voice/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/face'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    $fields = [
        'groupId' => $groupId,
        'video' => curl_file_create($filePath)
    ];
    curl_setopt($crl, CURLOPT_POSTFIELDS, $fields);
    return curl_exec($crl);
  }

  public function faceIdentificationByUrl($groupId, $fileUrl) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/face/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/video'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/identification/video/byUrl'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.'/token?timeOut='.strval($secondsToTimeout));
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function expireUserTokens($userId) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/users/'.$userId.'/expireTokens');
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function createUnmanagedSubAccount($firstName, $lastName, $email, $password, $contentLanguage) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/unmanaged'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/managed'.$this->notificationUrl);
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
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/'.$firstName.'/switchType'.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function regenerateSubAccountAPIToken($subAccountAPIKey) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/'.$subAccountAPIKey.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'POST');
    return curl_exec($crl);
  }

  public function deleteSubAccount($subAccountAPIKey) {
    $crl = createHandler();
    curl_setopt($crl, CURLOPT_URL, $this->baseUrl.'/subaccount/'.$subAccountAPIKey.$this->notificationUrl);
    curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    return curl_exec($crl);
  }

}
?>
