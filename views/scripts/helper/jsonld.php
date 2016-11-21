<?php if ( is_array($this->data) ) {?>

    <script type="application/ld+json">
        <?=json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)?>
    </script>

<?php } ?>