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

// $viapikey = getenv("VIAPIKEY");
// $viapitoken = getenv("VIAPITOKEN");
$viapikey = "key_f3a9fb29944a4e4180d4c98e7f03c713";
$viapitoken = "tok_be57cbfb92ae4e139f94843468095502";
$myVoiceIt = new VoiceIt\VoiceIt2($viapikey, $viapitoken);
$phrase = "Never forget tomorrow is a new day";

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
print "****Basic Tests All Passed****\n";

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

file_put_contents("./videoEnrollmentArmaan1.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan1.mov", 'r'));
file_put_contents("./videoEnrollmentArmaan2.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan2.mov", 'r'));
file_put_contents("./videoEnrollmentArmaan3.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan3.mov", 'r'));
file_put_contents("./videoVerificationArmaan1.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoVerificationArmaan1.mov", 'r'));
file_put_contents("./videoEnrollmentStephen1.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen1.mov", 'r'));
file_put_contents("./videoEnrollmentStephen2.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen2.mov", 'r'));
file_put_contents("./videoEnrollmentStephen3.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen3.mov", 'r'));

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", $phrase, "./videoEnrollmentArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", $phrase, "./videoEnrollmentArmaan2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", $phrase, "./videoEnrollmentArmaan3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", $phrase, "./videoEnrollmentStephen1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", $phrase, "./videoEnrollmentStephen2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", $phrase, "./videoEnrollmentStephen3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Verification
$ret = json_decode($myVoiceIt->videoVerification($userId1, "en-US", $phrase, "./videoVerificationArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Identification
$ret = json_decode($myVoiceIt->videoIdentification($groupId, "en-US", $phrase, "./videoVerificationArmaan1.mov"));
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
$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Verification By URL
$ret = json_decode($myVoiceIt->videoVerificationByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoVerificationArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Identification By URL
$ret = json_decode($myVoiceIt->videoIdentificationByUrl($groupId, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoVerificationArmaan1.mov"));
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

print "****Video Tests All Passed****\n";

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
file_put_contents("./enrollmentArmaan1.wav", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan1.wav", 'r'));
file_put_contents("./enrollmentArmaan2.wav", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan2.wav", 'r'));
file_put_contents("./enrollmentArmaan3.wav", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan3.wav", 'r'));
file_put_contents("./verificationArmaan1.wav", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/verificationArmaan1.wav", 'r'));
file_put_contents("./enrollmentStephen1.wav", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen1.wav", 'r'));
file_put_contents("./enrollmentStephen2.wav", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen2.wav", 'r'));
file_put_contents("./enrollmentStephen3.wav", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen3.wav", 'r'));

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", $phrase, "./enrollmentArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", $phrase, "./enrollmentArmaan2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", $phrase, "./enrollmentArmaan3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", $phrase, "./enrollmentStephen1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", $phrase, "./enrollmentStephen2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", $phrase, "./enrollmentStephen3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Verification
$ret = json_decode($myVoiceIt->voiceVerification($userId1, "en-US", $phrase, "./verificationArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Identification
$ret = json_decode($myVoiceIt->voiceIdentification($groupId, "en-US", $phrase, "./verificationArmaan1.wav"));
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
$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Verification By URL
$ret = json_decode($myVoiceIt->voiceVerificationByUrl($userId1, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/verificationArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Identification By URL
$ret = json_decode($myVoiceIt->voiceIdentificationByUrl($groupId, "en-US", $phrase, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/verificationArmaan1.wav"));
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

print "****Voice Tests All Passed****\n";

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
file_put_contents("./faceEnrollmentArmaan1.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan1.mp4", 'r'));
file_put_contents("./faceEnrollmentArmaan2.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan2.mp4", 'r'));
file_put_contents("./faceEnrollmentArmaan3.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan3.mp4", 'r'));
file_put_contents("./faceEnrollmentStephen1.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen1.mov", 'r'));
file_put_contents("./faceEnrollmentStephen2.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen2.mov", 'r'));
file_put_contents("./faceEnrollmentStephen3.mov", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen3.mov", 'r'));
file_put_contents("./faceVerificationArmaan1.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceVerificationArmaan1.mp4", 'r'));

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId1, "./faceEnrollmentArmaan1.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId1 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId1, "./faceEnrollmentArmaan2.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId2 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId1, "./faceEnrollmentArmaan3.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId3 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId2, "./faceEnrollmentStephen1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId2, "./faceEnrollmentStephen2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId2, "./faceEnrollmentStephen3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Verification
$ret = json_decode($myVoiceIt->faceVerification($userId1, "./faceVerificationArmaan1.mp4"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Identification
$ret = json_decode($myVoiceIt->faceIdentification($groupId, "./faceVerificationArmaan1.mp4"));
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

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId1, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan1.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId1 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId1, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan2.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId2 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId1, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan3.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId3 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId2, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId2, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createFaceEnrollmentByUrl($userId2, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Verification
$ret = json_decode($myVoiceIt->faceVerificationByUrl($userId1, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceVerificationArmaan1.mp4"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Face Identification
$ret = json_decode($myVoiceIt->faceIdentificationByUrl($groupId, "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceVerificationArmaan1.mp4"));
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

print "****Face Tests All Passed****\n";


unlink("./videoEnrollmentArmaan1.mov");
unlink("./videoEnrollmentArmaan2.mov");
unlink("./videoEnrollmentArmaan3.mov");
unlink("./videoVerificationArmaan1.mov");
unlink("./videoEnrollmentStephen1.mov");
unlink("./videoEnrollmentStephen2.mov");
unlink("./videoEnrollmentStephen3.mov");
unlink("./enrollmentArmaan1.wav");
unlink("./enrollmentArmaan2.wav");
unlink("./enrollmentArmaan3.wav");
unlink("./verificationArmaan1.wav");
unlink("./enrollmentStephen1.wav");
unlink("./enrollmentStephen2.wav");
unlink("./enrollmentStephen3.wav");
unlink("./faceEnrollmentArmaan1.mp4");
unlink("./faceEnrollmentArmaan2.mp4");
unlink("./faceEnrollmentArmaan3.mp4");
unlink("./faceVerificationArmaan1.mp4");
unlink("./faceEnrollmentStephen1.mov");
unlink("./faceEnrollmentStephen2.mov");
unlink("./faceEnrollmentStephen3.mov");
?>
