<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM categories WHERE id=" . $_GET['id'])->fetch_array();
    foreach ($qry as $k => $v) {
        $$k = htmlspecialchars_decode($v);
    }
}
?>

<div class="container-fluid">
    <form action="" id="manage-category">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>" class="form-control">
        <div class="row form-group">
            <div class="col-md-8">
                <label class="control-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-8">
                <label class="control-label">Description</label>
                <textarea name="description" class="form-control" id="text-jqte"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
            </div>
        </div>
        <?php if (isset($_GET['id'])) : ?>
            <input type="hidden" name="date_updated" value="<?php echo date('Y-m-d H:i:s'); ?>" class="form-control">
        <?php endif; ?>
        <!-- Add other fields specific to category management if necessary -->
    </form>
</div>

<script>
    $('#text-jqte').jqte();
    $('#manage-category').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_category',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved.", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
</script>