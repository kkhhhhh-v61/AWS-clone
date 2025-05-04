<?php require_once '../config/connect.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blooms Co. | Edit Account</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/accountset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</head>

<body>
    <?php
    include './adminheader.php';

    if (isset($_GET['id'])) {
        $edit_id = $_GET['id'];
        $sql = "SELECT * FROM user_table WHERE user_id = $edit_id";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_username = $row['username'];
            $user_email = $row['user_email'];
            $user_address = $row['user_address'];
            $user_contact = $row['user_phone'];
        } else {
            echo "<script>alert('User not found or invalid ID'); window.location.href = './adminaccount.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No user ID provided'); window.location.href = './adminaccount.php';</script>";
        exit();
    }
    ?>

    <div class="page-header">
        <h2>EDIT ACCOUNT</h2>
    </div>

    <div class="login-container">
        <div class="login-form">
            <div class="settingstitle">GENERAL INFORMATION
                <hr class="solid">
            </div>

            <!-- Profile Section -->
            <div class="profile-container">
                <?php
                // $row is guaranteed to be defined at this point
                echo "<img src='../php/user_images/{$row['user_image']}' class='profile-pic' alt='Profile Picture'>";
                ?>
            </div>

            <!-- User Details Section -->
            <div class="user-details-container">
                <div class="user-details">
                    <div class="detail-item" data-field="username">
                        <span class="detail-label">USERNAME</span>
                        <div class="detail-value" id="username-value"><?php echo htmlspecialchars($user_username); ?></div>
                        <input type="hidden" name="user_username" id="user_username" value="<?php echo htmlspecialchars($user_username); ?>">
                    </div>

                    <div class="detail-item" data-field="email">
                        <span class="detail-label">EMAIL</span>
                        <div class="detail-value" id="email-value"><?php echo htmlspecialchars($user_email); ?></div>
                        <input type="hidden" name="user_email" id="user_email" value="<?php echo htmlspecialchars($user_email); ?>">
                    </div>

                    <div class="detail-item" data-field="address">
                        <span class="detail-label">ADDRESS</span>
                        <div class="detail-value" id="address-value"><?php echo htmlspecialchars($user_address); ?></div>
                        <input type="hidden" name="user_address" id="user_address" value="<?php echo htmlspecialchars($user_address); ?>">
                    </div>

                    <div class="detail-item" data-field="phone">
                        <span class="detail-label">CONTACT</span>
                        <div class="detail-value" id="phone-value"><?php echo htmlspecialchars($user_contact); ?></div>
                        <input type="hidden" name="user_contact" id="user_contact" value="<?php echo htmlspecialchars($user_contact); ?>">
                    </div>
                </div>
            </div>

            <!-- Real-time edit script -->
            <script>
                // Inline Editing Handler
                document.addEventListener('DOMContentLoaded', function() {
                    const detailItems = document.querySelectorAll('.detail-item');

                    detailItems.forEach(item => {
                        const valueDiv = item.querySelector('.detail-value');
                        const field = item.dataset.field;
                        const input = item.querySelector('input[type="hidden"]');

                        valueDiv.addEventListener('click', function() {
                            const currentValue = this.textContent;

                            // Create input element
                            const editInput = document.createElement('input');
                            editInput.type = 'text';
                            editInput.className = 'edit-input';
                            editInput.value = currentValue;
                            editInput.style.width = 'calc(100% - 10px)';

                            // Hide value and show input
                            this.style.display = 'none';
                            item.insertBefore(editInput, this.nextSibling);
                            editInput.focus();

                            item.classList.add('editing');

                            // Handle blur (save changes)
                            editInput.addEventListener('blur', function() {
                                const newValue = this.value;
                                if (newValue !== currentValue) {
                                    // Update hidden input value
                                    input.value = newValue;

                                    // Send AJAX request to update the admin account
                                    fetch('update_admin_info.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            },
                                            body: new URLSearchParams({
                                                field: field,
                                                value: newValue,
                                                admin_id: '<?php echo $edit_id; ?>'
                                            }).toString()
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                valueDiv.textContent = newValue;
                                            } else {
                                                alert('Failed to update: ' + data.message);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            alert('Error updating information');
                                        });
                                }
                                valueDiv.style.display = 'block';
                                this.remove();
                                item.classList.remove('editing');
                            });

                            // Handle Enter key (save changes)
                            editInput.addEventListener('keypress', function(e) {
                                if (e.key === 'Enter') {
                                    this.blur();
                                }
                            });

                            // Handle Esc key (cancel editing)
                            editInput.addEventListener('keydown', function(e) {
                                if (e.key === 'Escape') {
                                    valueDiv.style.display = 'block';
                                    this.remove();
                                    item.classList.remove('editing');
                                }
                            });
                        });
                    });
                });
            </script>
        </div>
    </div>
    </div>
    </div>
    <?php include '../php/footer.php'; ?>


    <!-- editing products -->
    <?php
    if (isset($_POST['update_user'])) {
        $user_username = mysqli_real_escape_string($con, $_POST['user_username']);
        $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
        $user_address = mysqli_real_escape_string($con, $_POST['user_address']);
        $user_contact = mysqli_real_escape_string($con, $_POST['user_contact']);

        // checking if image is uploaded
        if (!empty($_FILES['user_image']['name'])) {
            $user_image = $_FILES['user_image']['name'];
            $temp_image1 = $_FILES['user_image']['tmp_name'];
        }

        // checking for fields empty or not
        if ($user_username == '' or $user_email == '' or $user_address == '' or $user_contact == '') {
            echo "<script>alert('Please fill all the fields and continue the process')</script>";
        } else {
            $update_user = "UPDATE user_table SET username='$user_username', user_email='$user_email', user_address='$user_address', user_phone='$user_contact' WHERE user_id=$edit_id";
            $result_update = mysqli_query($con, $update_user);
            if ($result_update) {
                echo "<script>alert('User updated successfully')</script>";
                echo "<script>window.open('./adminaccount.php','_self')</script>";
            }
        }
    }
    ?>

     
</body>

</html>