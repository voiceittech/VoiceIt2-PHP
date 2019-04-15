<?php
include('../voiceit/VoiceIt2.php');

function AssertEqual($arg1, $arg2, $line) {
  if ($arg1 != $arg2) {
    echo "{$arg1} does not equal {$arg2} in line {$line}";
    exit(1);
  }
}

function AssertTrue($passed) {
  if (!$passed) {
    echo "AssertTrue is false";
    exit(1);
  }
}

function AssertGreaterThan($arg1, $arg2, $line) {
  if ($arg1 <= $arg2) {
    echo "{$arg1} not greater than {$arg2} in line {$line}";
    exit(1);
  }
}

$viapikey = getenv("VIAPIKEY");
$viapitoken = getenv("VIAPITOKEN");
$myVoiceIt = new VoiceIt\VoiceIt2($viapikey, $viapitoken);

if (getenv("BOXFUSE_ENV") == "voiceittest") {
  file_put_contents(getenv("HOME")."/platformVersion", $myVoiceIt->getVersion());
}
$phrase = "Never forget tomorrow is a new day";

// ****TEST WEBHOOKS****
$myVoiceIt->addNotificationUrl("https://voiceit.io");
AssertEqual("?notificationURL=https%3A%2F%2Fvoiceit.io", $myVoiceIt->getNotificationUrl(), __LINE__);
$myVoiceIt->removeNotificationUrl();
AssertEqual("", $myVoiceIt->getNotificationUrl(), __LINE__);
print "**** Webhook Tests All Passed ****\n";

// ****TEST BASICS****

// Get All Phrases
$ret = json_decode($myVoiceIt->getPhrases("en-US"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Create User
$ret = json_decode($myVoiceIt->createUser());
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};

// Get All Users
$ret = json_decode($myVoiceIt->getAllUsers());
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$users = $ret ->{"users"};
AssertGreaterThan(count($users), 1, __LINE__);

// Check if a Specific User Exists
$ret = json_decode($myVoiceIt->checkUserExists($userId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Create Group
$ret = json_decode($myVoiceIt->createGroup("Sample Group Description"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$groupId = $ret ->{"groupId"};

// Get All Groups
$ret = json_decode($myVoiceIt->getAllGroups());
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$groups = $ret ->{"groups"};
AssertGreaterThan(count($groups), 1, __LINE__);

// Get a Specific Group
$ret = json_decode($myVoiceIt->getGroup($groupId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Check if Group Exists
$ret = json_decode($myVoiceIt->groupExists($groupId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Add User to Group
$ret = json_decode($myVoiceIt->addUserToGroup($groupId, $userId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Get Groups for User
$ret = json_decode($myVoiceIt->getGroupsForUser($userId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$groups = $ret ->{"groups"};
AssertGreaterThan(count($groups), 0, __LINE__);
AssertEqual($groupId, $groups[0], __LINE__);

// Remove User from Group
$ret = json_decode($myVoiceIt->removeUserFromGroup($groupId, $userId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Create User Token
$ret = json_decode($myVoiceIt->createUserToken($userId, 5));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Expire User Tokens
$ret = json_decode($myVoiceIt->expireUserTokens($userId));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete User
$ret = json_decode($myVoiceIt->deleteUser($userId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete Group
$ret = json_decode($myVoiceIt->deleteGroup($groupId));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
print "**** Basic Tests All Passed ****\n";

// Check file doesn't exist
try {
  json_decode($myVoiceIt->createVideoEnrollment("", "", "", "fake_file"));
  json_decode($myVoiceIt->createVoiceEnrollment("", "", "", "fake_file"));
  json_decode($myVoiceIt->createFaceEnrollment("", "fake_file"));
  json_decode($myVoiceIt->voiceVerification("", "", "", "fake_file"));
  json_decode($myVoiceIt->faceVerification("", "fake_file"));
  json_decode($myVoiceIt->videoVerification("", "", "", "fake_file"));
  json_decode($myVoiceIt->voiceIdentification("", "", "", "fake_file"));
  json_decode($myVoiceIt->faceIdentification("", "fake_file"));
  json_decode($myVoiceIt->videoIdentification("", "", "", "fake_file"));

  AssertTrue(False);
} catch (Exception $e) {
  AssertEqual($e->getMessage(), "File fake_file does not exist", __LINE__);
}


// ****TEST VIDEO****
$ret = json_decode($myVoiceIt->createUser());
$userId1 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createUser());
$userId2 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createGroup("Sample Group Description"));
$groupId = $ret ->{"groupId"};
$myVoiceIt->addUserToGroup($groupId, $userId1);
$myVoiceIt->addUserToGroup($groupId, $userId2);

// Create Video Enrollments

file_put_contents("./videoEnrollmentB1.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentB1.mov", 'r'));
file_put_contents("./videoEnrollmentB2.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentB2.mov", 'r'));
file_put_contents("./videoEnrollmentB3.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentB3.mov", 'r'));
file_put_contents("./videoVerificationB1.mov", fopen("https://drive.voiceit.io/files/videoVerificationB1.mov", 'r'));
file_put_contents("./videoEnrollmentC1.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentC1.mov", 'r'));
file_put_contents("./videoEnrollmentC2.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentC2.mov", 'r'));
file_put_contents("./videoEnrollmentC3.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentC3.mov", 'r'));

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", $phrase, "./videoEnrollmentB1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", $phrase, "./videoEnrollmentB2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", $phrase, "./videoEnrollmentB3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", $phrase, "./videoEnrollmentC1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", $phrase, "./videoEnrollmentC2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", $phrase, "./videoEnrollmentC3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Verification
$ret = json_decode($myVoiceIt->videoVerification($userId1, "en-US", $phrase, "./videoVerificationB1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Identification
$ret = json_decode($myVoiceIt->videoIdentification($groupId, "en-US", $phrase, "./videoVerificationB1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

// Delete Enrollments individually
$ret = json_decode($myVoiceIt->deleteVideoEnrollment($userId1, $enrollmentId1));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteVideoEnrollment($userId1, $enrollmentId2));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteVideoEnrollment($userId1, $enrollmentId3));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete All Enrollments for User
$ret = json_decode($myVoiceIt->deleteAllVideoEnrollments($userId2));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);


// By URL
$myVoiceIt->deleteUser($userId1);
$myVoiceIt->deleteUser($userId2);
$myVoiceIt->deleteGroup($groupId);
$ret = json_decode($myVoiceIt->createUser());
$userId1 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createUser());
$userId2 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createGroup("Sample Group Description"));
$groupId = $ret ->{"groupId"};
$myVoiceIt->addUserToGroup($groupId, $userId1);
$myVoiceIt->addUserToGroup($groupId, $userId2);

// Create Video Enrollments By URL
$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/videoEnrollmentB1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/videoEnrollmentB2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/videoEnrollmentB3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", $phrase, "https://drive.voiceit.io/files/videoEnrollmentC1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", $phrase, "https://drive.voiceit.io/files/videoEnrollmentC2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", $phrase, "https://drive.voiceit.io/files/videoEnrollmentC3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Verification By URL
$ret = json_decode($myVoiceIt->videoVerificationByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/videoVerificationB1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Identification By URL
$ret = json_decode($myVoiceIt->videoIdentificationByUrl($groupId, "en-US", $phrase, "https://drive.voiceit.io/files/videoVerificationB1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

$myVoiceIt->deleteAllEnrollments($userId1);
$myVoiceIt->deleteAllEnrollments($userId2);
$myVoiceIt->deleteUser($userId1);
$myVoiceIt->deleteUser($userId2);
$myVoiceIt->deleteGroup($groupId);

print "**** Video Tests All Passed ****\n";

// ****TEST VOICE****
$ret = json_decode($myVoiceIt->createUser());
$userId1 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createUser());
$userId2 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createGroup("Sample Group Description"));
$groupId = $ret ->{"groupId"};
$myVoiceIt->addUserToGroup($groupId, $userId1);
$myVoiceIt->addUserToGroup($groupId, $userId2);

// Create Voice Enrollments
file_put_contents("./enrollmentA1.wav", fopen("https://drive.voiceit.io/files/enrollmentA1.wav", 'r'));
file_put_contents("./enrollmentA2.wav", fopen("https://drive.voiceit.io/files/enrollmentA2.wav", 'r'));
file_put_contents("./enrollmentA3.wav", fopen("https://drive.voiceit.io/files/enrollmentA3.wav", 'r'));
file_put_contents("./verificationA1.wav", fopen("https://drive.voiceit.io/files/verificationA1.wav", 'r'));
file_put_contents("./enrollmentC1.wav", fopen("https://drive.voiceit.io/files/enrollmentC1.wav", 'r'));
file_put_contents("./enrollmentC2.wav", fopen("https://drive.voiceit.io/files/enrollmentC2.wav", 'r'));
file_put_contents("./enrollmentC3.wav", fopen("https://drive.voiceit.io/files/enrollmentC3.wav", 'r'));

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", $phrase, "./enrollmentA1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", $phrase, "./enrollmentA2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", $phrase, "./enrollmentA3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", $phrase, "./enrollmentC1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", $phrase, "./enrollmentC2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", $phrase, "./enrollmentC3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Verification
$ret = json_decode($myVoiceIt->voiceVerification($userId1, "en-US", $phrase, "./verificationA1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Identification
$ret = json_decode($myVoiceIt->voiceIdentification($groupId, "en-US", $phrase, "./verificationA1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

// Delete Enrollments individually
$ret = json_decode($myVoiceIt->deleteVoiceEnrollment($userId1, $enrollmentId1));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteVoiceEnrollment($userId1, $enrollmentId2));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteVoiceEnrollment($userId1, $enrollmentId3));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete All Enrollments
$myVoiceIt->deleteAllVoiceEnrollments($userId2);

// By URL
$myVoiceIt->deleteUser($userId1);
$myVoiceIt->deleteUser($userId2);
$myVoiceIt->deleteGroup($groupId);
$ret = json_decode($myVoiceIt->createUser());
$userId1 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createUser());
$userId2 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createGroup("Sample Group Description"));
$groupId = $ret ->{"groupId"};
$myVoiceIt->addUserToGroup($groupId, $userId1);
$myVoiceIt->addUserToGroup($groupId, $userId2);

// Create Voice Enrollments By URL
$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/enrollmentA1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/enrollmentA2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/enrollmentA3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", $phrase, "https://drive.voiceit.io/files/enrollmentC1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", $phrase, "https://drive.voiceit.io/files/enrollmentC2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", $phrase, "https://drive.voiceit.io/files/enrollmentC3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Verification By URL
$ret = json_decode($myVoiceIt->voiceVerificationByUrl($userId1, "en-US", $phrase, "https://drive.voiceit.io/files/verificationA1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Identification By URL
$ret = json_decode($myVoiceIt->voiceIdentificationByUrl($groupId, "en-US", $phrase, "https://drive.voiceit.io/files/verificationA1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

$myVoiceIt->deleteAllVoiceEnrollments($userId1);
$myVoiceIt->deleteAllVoiceEnrollments($userId2);
$myVoiceIt->deleteUser($userId1);
$myVoiceIt->deleteUser($userId2);
$myVoiceIt->deleteGroup($groupId);

print "**** Voice Tests All Passed ****\n";

// ****TEST FACE****
$ret = json_decode($myVoiceIt->createUser());
$userId1 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createUser());
$userId2 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createGroup("Sample Group Description"));
$groupId = $ret ->{"groupId"};
$myVoiceIt->addUserToGroup($groupId, $userId1);
$myVoiceIt->addUserToGroup($groupId, $userId2);

// Create Face Enrollments
file_put_contents("./faceEnrollmentB1.mp4", fopen("https://drive.voiceit.io/files/faceEnrollmentB1.mp4", 'r'));
file_put_contents("./faceEnrollmentB2.mp4", fopen("https://drive.voiceit.io/files/faceEnrollmentB2.mp4", 'r'));
file_put_contents("./faceEnrollmentB3.mp4", fopen("https://drive.voiceit.io/files/faceEnrollmentB3.mp4", 'r'));
file_put_contents("./faceEnrollmentC1.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentC1.mov", 'r'));
file_put_contents("./faceEnrollmentC2.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentC2.mov", 'r'));
file_put_contents("./faceEnrollmentC3.mov", fopen("https://drive.voiceit.io/files/videoEnrollmentC3.mov", 'r'));
file_put_contents("./faceVerificationB1.mp4", fopen("https://drive.voiceit.io/files/faceVerificationB1.mp4", 'r'));

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId1, "./faceEnrollmentB1.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId1 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId1, "./faceEnrollmentB2.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId2 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId1, "./faceEnrollmentB3.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId3 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId2, "./faceEnrollmentC1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId2, "./faceEnrollmentC2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId2, "./faceEnrollmentC3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Verification
$ret = json_decode($myVoiceIt->faceVerification($userId1, "./faceVerificationB1.mp4"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Identification
$ret = json_decode($myVoiceIt->faceIdentification($groupId, "./faceVerificationB1.mp4"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete Face Enrollments Individually
$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId1, $faceEnrollmentId1));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId1, $faceEnrollmentId2));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId1, $faceEnrollmentId3));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$myVoiceIt->deleteAllFaceEnrollments($userId2);

$myVoiceIt->deleteUser($userId1);
$myVoiceIt->deleteUser($userId2);
$myVoiceIt->deleteGroup($groupId);

// By URL

$ret = json_decode($myVoiceIt->createUser());
$userId1 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createUser());
$userId2 = $ret ->{"userId"};
$ret = json_decode($myVoiceIt->createGroup("Sample Group Description"));
$groupId = $ret ->{"groupId"};
$myVoiceIt->addUserToGroup($groupId, $userId1);
$myVoiceIt->addUserToGroup($groupId, $userId2);

// Create Face Enrollments

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId1, "https://drive.voiceit.io/files/faceEnrollmentB1.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId1 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId1, "https://drive.voiceit.io/files/faceEnrollmentB2.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId2 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId1, "https://drive.voiceit.io/files/faceEnrollmentB3.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId3 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId2, "https://drive.voiceit.io/files/videoEnrollmentC1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId2, "https://drive.voiceit.io/files/videoEnrollmentC2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId2, "https://drive.voiceit.io/files/videoEnrollmentC3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Verification
$ret = json_decode($myVoiceIt->faceVerificationByUrl($userId1, "https://drive.voiceit.io/files/faceVerificationB1.mp4"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Identification
$ret = json_decode($myVoiceIt->faceIdentificationByUrl($groupId, "https://drive.voiceit.io/files/faceVerificationB1.mp4"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete Face Enrollments Individually
$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId1, $faceEnrollmentId1));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId1, $faceEnrollmentId2));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId1, $faceEnrollmentId3));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$myVoiceIt->deleteAllFaceEnrollments($userId2);

$myVoiceIt->deleteUser($userId1);
$myVoiceIt->deleteUser($userId2);
$myVoiceIt->deleteGroup($groupId);

print "**** Face Tests All Passed ****\n";


unlink("./videoEnrollmentB1.mov");
unlink("./videoEnrollmentB2.mov");
unlink("./videoEnrollmentB3.mov");
unlink("./videoVerificationB1.mov");
unlink("./videoEnrollmentC1.mov");
unlink("./videoEnrollmentC2.mov");
unlink("./videoEnrollmentC3.mov");
unlink("./enrollmentA1.wav");
unlink("./enrollmentA2.wav");
unlink("./enrollmentA3.wav");
unlink("./verificationA1.wav");
unlink("./enrollmentC1.wav");
unlink("./enrollmentC2.wav");
unlink("./enrollmentC3.wav");
unlink("./faceEnrollmentB1.mp4");
unlink("./faceEnrollmentB2.mp4");
unlink("./faceEnrollmentB3.mp4");
unlink("./faceVerificationB1.mp4");
unlink("./faceEnrollmentC1.mov");
unlink("./faceEnrollmentC2.mov");
unlink("./faceEnrollmentC3.mov");
?>
