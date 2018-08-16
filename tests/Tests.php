<?php
include('../voiceit/VoiceIt2.php');

function AssertEqual($arg1, $arg2, $line) {
  if ($arg1 != $arg2) {
    echo "{$arg1} does not equal {$arg2} in line {$line}";
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

// ****TEST BASICS****
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

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", "./videoEnrollmentArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", "./videoEnrollmentArmaan2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId1, "en-US", "./videoEnrollmentArmaan3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", "./videoEnrollmentStephen1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", "./videoEnrollmentStephen2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollment($userId2, "en-US", "./videoEnrollmentStephen3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Verification
$ret = json_decode($myVoiceIt->videoVerification($userId1, "en-US", "./videoVerificationArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Identification
$ret = json_decode($myVoiceIt->videoIdentification($groupId, "en-US", "./videoVerificationArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

// Delete Enrollments individually
$ret = json_decode($myVoiceIt->deleteEnrollmentForUser($userId1, $enrollmentId1));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteEnrollmentForUser($userId1, $enrollmentId2));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteEnrollmentForUser($userId1, $enrollmentId3));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete All Enrollments for User
$ret = json_decode($myVoiceIt->deleteAllEnrollmentsForUser($userId2));
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
$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId1 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId2 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentArmaan3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$enrollmentId3 = $ret ->{"id"};

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen1.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen2.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVideoEnrollmentByUrl($userId2, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoEnrollmentStephen3.mov"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Verification By URL
$ret = json_decode($myVoiceIt->videoVerificationByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoVerificationArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Video Identification By URL
$ret = json_decode($myVoiceIt->videoIdentificationByUrl($groupId, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/videoVerificationArmaan1.mov"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

$myVoiceIt->deleteAllEnrollmentsForUser($userId1);
$myVoiceIt->deleteAllEnrollmentsForUser($userId2);
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

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", "./enrollmentArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", "./enrollmentArmaan2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId1, "en-US", "./enrollmentArmaan3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", "./enrollmentStephen1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", "./enrollmentStephen2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollment($userId2, "en-US", "./enrollmentStephen3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Verification
$ret = json_decode($myVoiceIt->voiceVerification($userId1, "en-US", "./verificationArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Identification
$ret = json_decode($myVoiceIt->voiceIdentification($groupId, "en-US", "./verificationArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

$myVoiceIt->deleteAllEnrollmentsForUser($userId1);
$myVoiceIt->deleteAllEnrollmentsForUser($userId2);

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
$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentArmaan3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen1.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen2.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->createVoiceEnrollmentByUrl($userId2, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/enrollmentStephen3.wav"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Verification By URL
$ret = json_decode($myVoiceIt->voiceVerificationByUrl($userId1, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/verificationArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Voice Identification By URL
$ret = json_decode($myVoiceIt->voiceIdentificationByUrl($groupId, "en-US", "https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/verificationArmaan1.wav"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$userId = $ret ->{"userId"};
AssertEqual($userId1, $userId, __LINE__);

$myVoiceIt->deleteAllEnrollmentsForUser($userId1);
$myVoiceIt->deleteAllEnrollmentsForUser($userId2);
$myVoiceIt->deleteUser($userId1);
$myVoiceIt->deleteUser($userId2);
$myVoiceIt->deleteGroup($groupId);

print "****Voice Tests All Passed****\n";

// ****TEST FACE****
$ret = json_decode($myVoiceIt->createUser());
$userId = $ret ->{"userId"};

// Create Face Enrollments
file_put_contents("./faceEnrollmentArmaan1.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan1.mp4", 'r'));
file_put_contents("./faceEnrollmentArmaan2.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan2.mp4", 'r'));
file_put_contents("./faceEnrollmentArmaan3.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceEnrollmentArmaan3.mp4", 'r'));
file_put_contents("./faceVerificationArmaan1.mp4", fopen("https://s3.amazonaws.com/voiceit-api2-testing-files/test-data/faceVerificationArmaan1.mp4", 'r'));

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId, "./faceEnrollmentArmaan1.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId1 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId, "./faceEnrollmentArmaan2.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId2 = $ret ->{"faceEnrollmentId"};

$ret = json_decode($myVoiceIt->createFaceEnrollment($userId, "./faceEnrollmentArmaan3.mp4"));
$status = $ret ->{"status"};
AssertEqual(201, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);
$faceEnrollmentId3 = $ret ->{"faceEnrollmentId"};

// Face Verification
$ret = json_decode($myVoiceIt->faceVerification($userId, "./faceVerificationArmaan1.mp4"));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

// Delete Face Enrollments Individually
$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId, $faceEnrollmentId1));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId, $faceEnrollmentId2));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$ret = json_decode($myVoiceIt->deleteFaceEnrollment($userId, $faceEnrollmentId3));
$status = $ret ->{"status"};
AssertEqual(200, $status, __LINE__);
$responseCode = $ret ->{"responseCode"};
AssertEqual("SUCC", $responseCode, __LINE__);

$myVoiceIt->deleteUser($userId);

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
?>
