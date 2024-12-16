<?php include 'header.php'; ?>
<h2>Profile</h2>
<form action="process_profile.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="New Password">
    <button type="submit" name="update_profile">Update Profile</button>
</form>
<?php include '../footer.php'; ?>
