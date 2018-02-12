<?php if (isset($this->_msj_error)): ?>
    <div id="mensaje" class="alert alert-warning" style="display: block;">
        <?php
        if (is_array($this->_msj_error)) {
            foreach ($this->_msj_error as $error) {
                echo $error;
            }
        } else {
            echo $this->_msj_error;
        }
        ?></div>
<?php endif; ?>
