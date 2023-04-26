<?php include '../include/header.php'; ?>
<?php if ($_SESSION['role'] == 'MARKETING') { ?>
<?php include '../include/preloader.php'; ?>
<?php include '../include/navbar.php'; ?>
<?php include '../include/sidebar.php'; ?>

  <?php include '../sales-report.php'; ?>

<?php include '../include/footer.php'; ?>
<?php } else { echo "<script>window.location='../../login.php'</script>"; } ?>