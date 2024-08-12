<?php

$action = $_REQUEST['action'] ?? '';

if (!empty($action)) {
    require_once 'partials/User.php';
    $obj = new User();
}

// Adding user action
if ($action == 'adduser' && !empty($_POST)) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];
    $profile_picture = '';


    $errors = [];

    if (empty($firstname)) {
        $errors['firstname'] = "First name is required";
    }
    
    if (empty($lastname)) {
        $errors['lastname'] = "Last name is required";
    }
    
    $emailPattern =  '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } else if(!preg_match($emailPattern, $email)){
        $errors['email'] = "Invalid email";
    } else if(!empty($email)){
        if($obj->emailExists($email)){
            $errors["email"] =   "Email already exists";
        }
    }
    
    
    $mobilePattern = '/^[0-9]{10}$/';
    if (empty($mobile)) {
        $errors['mobile'] = "Mobile is required";
    } else if(!preg_match($mobilePattern, $mobile)) {
        $errors['mobile'] = "Must include 10 numbers";
    }
    
    $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/';
    
 
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $password)) {
        $errors['password'] = "At least 6 characters including lower, upper, number, and special character";
    }
    
    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = "Passwords do not match";
    }

    if (!empty($_FILES['photo']['name'])) {
        $fileName = $_FILES['photo']['name'];
        $fileTmpName = $_FILES['photo']['tmp_name'];
        $fileSize = $_FILES['photo']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpeg', 'jpg', 'png', 'jfif'];

        if (!in_array($fileExt, $allowed)) {
            $errors['profile_picture'] = "Invalid file type. Only JPEG, JPG, and PNG are allowed.";
        }

        if ($fileSize > 100000) {
            $errors['profile_picture'] = "File size exceeds 100KB.";
        }

        if (empty($errors)) {
            $profile_picture = time().'.'.$fileExt;
            $folderpath = 'uploads/'. $profile_picture;
            move_uploaded_file($fileTmpName, $folderpath);
        }
    } else{
        $errors['profile_picture'] = 'Please upload image';
    }
    

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $userData = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'mobile' => $mobile,
        'photo'=> $profile_picture,
        'password' => $passwordHash,
    ];

 
    $userid = $obj->add($userData);
    
    
    if (!empty($userid)) {
        $user = $obj->getRow('id', $userid);
        echo json_encode(['success' => true, 'user' => $user]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add user']);
        exit();
    }
}

//updating user

if ($action == 'updateuser' && !empty($_POST)) {
    $firstname = $_POST['updatefirstname'];
    $lastname = $_POST['updatelastname'];
    $email = $_POST['updateemail'];
    $mobile = $_POST['updatemobile'];
    $profile_picture = $_FILES['update_photo'];

    $userid = $_POST['updateuserid'];


    $errors = [];

    if (empty($firstname)) {
        $errors['firstname'] = "First name is required";
    }
    
    if (empty($lastname)) {
        $errors['lastname'] = "Last name is required";
    }
    
    $emailPattern =  '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } else if(!preg_match($emailPattern, $email)){
        $errors['email'] = "Invalid email";
    } else if(!empty($email)){
        if($obj->emailExistforupdate($email, $userid)){
            $errors["email"] =   "Email already exists";
        }
    }
    
    $mobilePattern = '/^[0-9]{10}$/';
    if (empty($mobile)) {
        $errors['mobile'] = "Mobile is required";
    } else if(!preg_match($mobilePattern, $mobile)) {
        $errors['mobile'] = "Must include 10 numbers";
    }

    $currentUser = $obj->getRow('id', $userid);
    $existingPhoto = $currentUser['photo'];

    if (!empty($_FILES['update_photo']['name'])) {
        $fileName = $_FILES['update_photo']['name'];
        $fileTmpName = $_FILES['update_photo']['tmp_name'];
        $fileSize = $_FILES['update_photo']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpeg', 'jpg', 'png', 'jfif'];
    
        if (!in_array($fileExt, $allowed)) {
            $errors['profile_picture'] = "Invalid file type. Only JPEG, JPG, and PNG are allowed.";
        }
    
        if ($fileSize > 100000) {
            $errors['profile_picture'] = "File size exceeds 100KB.";
        }
    
        if (empty($errors)) {
            $profile_picture = time() . '.' . $fileExt;
            $folderpath = 'uploads/'. $profile_picture;
            move_uploaded_file($fileTmpName, $folderpath);
        } else{
            $profile_picture = $existingPhoto;
        }
    } else{
        $profile_picture = $existingPhoto;
    }
    
   

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        exit();
    }


    $userData = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'mobile' => $mobile,
        'photo'=> $profile_picture,
    ];

    $obj->update($userData, $userid);

    
    if (!empty($userid)) {
        $user = $obj->getRow('id', $userid);
        echo json_encode(['success' => true, 'user' => $user]);
        exit();
    } 
}


// Get all users action
if ($action == 'getallusers') {
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 5;
    $start = ($page - 1) * $limit;
    
    $users = $obj->getRows($start, $limit);
    $total = $obj->getCount();
    
    $userArr = ['count' => $total, 'users' => $users];
    echo json_encode($userArr);
    exit();
}

// action to perform editing
if($action == "edituserdata"){
    $playerId = $_GET['id'] ?? '';
    if(!empty($playerId)){
        $user = $obj->getRow('id', $playerId);
        echo json_encode($user);
        exit();
    }
}


//perform deleting
if($action == 'deleteuser'){
    $userId = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if(!empty($userId)){
        $isdeleted = $obj->deleteRow($userId);
        if($isdeleted){
            $displaymessage = ['deleted' => 1];
        } else{
            $displaymessage = ['deleted' => 0];
        }
        echo json_encode($displaymessage);
        exit();
    }
}

//search data
if($action == "searchuser"){
    $queryString = (!empty($_GET['searchQuery'])) ? trim($_GET['searchQuery']) : '';
    $current_id = (!empty($_GET['current_id'])) ? $_GET['current_id'] : '';
    $results = $obj->searchuser($queryString, $current_id);
    echo json_encode($results);
    exit();
}
?>