<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="<?= ASSETS ?>css/bootstrap.min.css" />
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="<?= ASSETS ?>css/components/navbar.component.css">
<link rel="stylesheet" href="<?= ASSETS ?>css/components/footer-section.component.css" />
<link rel="stylesheet" href="<?= ASSETS ?>css/components/ai-component.css" />

<link rel="stylesheet" href="<?= ASSETS ?>css/Collections.css">



<?php include VIEW_PATH . 'components/navbar.php'; ?>

<div style="margin-top:200px" class="documentNotNavbar container">
    <h2>Edit Profile</h2>

    <form action="<?= BASE_URL ?>profile/update" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                value="<?= htmlspecialchars($_SESSION['user']['name']) ?>" required>
        </div>

        <input type="email" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" disabled>


        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>
        <button class="btn btn-primary">Save Changes</button>
    </form>
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] === 'invalid_image'): ?>
            <div class="alert alert-danger">
                Only JPG, PNG, and WEBP images are allowed.
            </div>
        <?php elseif ($_GET['error'] === 'invalid_name'): ?>
            <div class="alert alert-danger">
                Name must be at least 3 characters.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success text-center">
            تم تحديث البيانات بنجاح، سيتم تحويلك للصفحة الرئيسية خلال 3 ثوانٍ
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "<?= BASE_URL ?>";
            }, 3000);
        </script>
    <?php endif; ?>


</div>


<?php include VIEW_PATH . 'components/footer.php'; ?>

<?php include VIEW_PATH . 'components/ai.php'; ?>
<script src="<?= ASSETS ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= ASSETS ?>js/navbar.component.js"></script>
<script src="<?= ASSETS ?>js/ai.js"></script>