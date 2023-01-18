<script>
    let BASE_URL = <?php echo json_encode(BASE_URL, JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?php echo ASSETS_URL ?>/js/jquery-3.6.0.min.js"></script>
<script src="<?php echo ASSETS_URL ?>/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo ASSETS_URL ?>/js/main.js"></script>

<?php if( ShellaiDev\Models\System\File::areFleshMessagesPresent() ): ?>
    <script>
        $(function(){
            let flesh = {
                status: <?php echo json_encode($status, JSON_UNESCAPED_UNICODE) ?>,
                message: <?php echo json_encode($message, JSON_UNESCAPED_UNICODE) ?>,
            };
            showMessage(flesh.status, flesh.message);
        });
    </script>
<?php endif; ?>
