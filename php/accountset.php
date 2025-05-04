<?php
require_once '../config/connect.php';

// Start the session
@session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit;
}

// Handle form submission
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Verify user credentials
    $select_query = "SELECT * FROM user_table WHERE username = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row_data = mysqli_fetch_assoc($result);
        if ($row_data) {
            if (password_verify($current_password, $row_data['user_password'])) {
                if ($new_password === $confirm_new_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query = "UPDATE user_table SET user_password = ? WHERE username = ?";
                    $stmt = mysqli_prepare($con, $update_query);
                    mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $_SESSION['username']);
                    $update_result = mysqli_stmt_execute($stmt);

                    if ($update_result) {
                        echo "<script>alert('Password changed successfully')</script>";
                    } else {
                        echo "<script>alert('Failed to update password')</script>";
                    }
                } else {
                    echo "<script>alert('New passwords do not match')</script>";
                }
            } else {
                echo "<script>alert('Incorrect current password')</script>";
            }
        } else {
            echo "<script>alert('User not found')</script>";
        }
    } else {
        echo "<script>alert('Failed to fetch user data')</script>";
    }
}

// Get user details for display
$user_info_query = "SELECT ut.user_id, ut.username, ut.user_email, ut.user_address, ut.user_phone, ut.user_image 
                   FROM user_table ut 
                   WHERE ut.username = ?";
$stmt = mysqli_prepare($con, $user_info_query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
mysqli_stmt_execute($stmt);
$user_info_result = mysqli_stmt_get_result($stmt);

// Get user image (included in the main query above)
?>

<?php
require_once '../config/helper.php';
$username = $_SESSION['username'];
$user_info_query = "SELECT username, user_email, user_address, user_phone, user_image FROM user_table WHERE username = '$username'";
$user_info_result = mysqli_query($con, $user_info_query);
$row = mysqli_fetch_assoc($user_info_result);
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blooms Co. | Account</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/accountset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</head>

<body>
    <?php include './header.php'; ?>

    <div class="page-header">
        <h2>ACCOUNT</h2>
    </div>

    <div class="login-container">
        <div class="login-form">
            <div class="settingstitle">GENERAL INFORMATION
                <hr class="solid">
            </div>

            <!-- Profile Section -->
            <div class="profile-container">
                <?php
                if ($row) {
                    echo "<img src='./user_images/{$row['user_image']}' class='profile-pic' alt='Profile Picture'>";
                } else {
                    echo "<img src='./user_images/default.png' class='profile-pic' alt='Default Profile Picture'>";
                }
                ?>
            </div>

            <!-- User Details Section -->
            <div class="user-details-container">
                <div class="user-details">
                    <?php
                    if ($row) {
                        // Username
                        echo "<div class='detail-item' data-field='username'>
                        <span class='detail-label'>USERNAME</span>
                        <span class='detail-value'>" . $row['username'] . "</span>
                    </div>";

                        // Email
                        echo "<div class='detail-item' data-field='email'>
                        <span class='detail-label'>EMAIL</span>
                        <span class='detail-value'>" . $row['user_email'] . "</span>
                    </div>";

                        // Address
                        echo "<div class='detail-item' data-field='address'>
                        <span class='detail-label'>ADDRESS</span>
                        <span class='detail-value'>" . $row['user_address'] . "</span>
                    </div>";

                        // Contact
                        echo "<div class='detail-item' data-field='phone'>
                        <span class='detail-label'>CONTACT</span>
                        <span class='detail-value'>" . $row['user_phone'] . "</span>
                    </div>";
                    } else {
                        echo "<div class='detail-item'>
                        <p>No user details found. Please try refreshing the page.</p>
                    </div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="settingstitle2">CHANGE PASSWORD
                <hr class="solid">
            </div>

            <form action="edit_account.php" method="post" class="user-details-container">
                <div class="user-details">
                    <div class="detail-item" data-field="current_password">
                        <label for="current_password" class="detail-label">CURRENT PASSWORD</label>
                        <div class="password-input-container">
                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter your current password" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility1()">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                        </div>
                    </div>

                    <div class="detail-item" data-field="new_password">
                        <label for="new_password" class="detail-label">NEW PASSWORD</label>
                        <div class="password-input-container">
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter your new password" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility2()">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                        </div>
                    </div>

                    <div class="detail-item" data-field="confirm_password">
                        <label for="confirm_new_password" class="detail-label">CONFIRM NEW PASSWORD</label>
                        <div class="password-input-container">
                            <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="Confirm your new password" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility3()">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="change_password" class="btn4">CHANGE PASSWORD</button>
                </div>
            </form>

        </div>
    </div>

    <?php include './footer.php'; ?>

    <!-- Scripts -->
    <script>
        // Password Visibility Toggle Functions
        function togglePasswordVisibility1() {
            const passwordInput = document.getElementById('current_password');
            const toggleButton = document.querySelector('#current_password + button');
            const icon = toggleButton.querySelector('ion-icon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.name = "eye-off-outline";
            } else {
                passwordInput.type = "password";
                icon.name = "eye-outline";
            }
        }

        function togglePasswordVisibility2() {
            const passwordInput = document.getElementById('new_password');
            const toggleButton = document.querySelector('#new_password + button');
            const icon = toggleButton.querySelector('ion-icon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.name = "eye-off-outline";
            } else {
                passwordInput.type = "password";
                icon.name = "eye-outline";
            }
        }

        function togglePasswordVisibility3() {
            const passwordInput = document.getElementById('confirm_new_password');
            const toggleButton = document.querySelector('#confirm_new_password + button');
            const icon = toggleButton.querySelector('ion-icon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.name = "eye-off-outline";
            } else {
                passwordInput.type = "password";
                icon.name = "eye-outline";
            }
        }

        // Inline Editing Handler
        document.addEventListener('DOMContentLoaded', function() {
            const detailItems = document.querySelectorAll('.detail-item');

            detailItems.forEach(item => {
                const valueSpan = item.querySelector('.detail-value');
                const field = item.dataset.field;

                valueSpan.addEventListener('click', function() {
                    const currentValue = this.textContent;

                    // Create input element
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'edit-input';
                    input.value = currentValue;
                    input.style.width = 'calc(100% - 10px)';

                    // Hide value and show input
                    this.style.display = 'none';
                    item.insertBefore(input, this.nextSibling);
                    input.focus();

                    item.classList.add('editing');

                    // Handle blur (save changes)
                    input.addEventListener('blur', function() {
                        const newValue = this.value;
                        if (newValue !== currentValue) {
                            // Send AJAX request to update the field
                            fetch('update_user_info.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: new URLSearchParams({
                                        field: field,
                                        value: newValue,
                                        username: '<?php echo $_SESSION["username"]; ?>'
                                    }).toString()
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        valueSpan.textContent = newValue;
                                    } else {
                                        alert('Failed to update: ' + data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error updating information');
                                });
                        }
                        valueSpan.style.display = 'block';
                        this.remove();
                        item.classList.remove('editing');
                    });

                    // Handle Enter key (save changes)
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            this.blur();
                        }
                    });

                    // Handle Esc key (cancel editing)
                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            valueSpan.style.display = 'block';
                            this.remove();
                            item.classList.remove('editing');
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>