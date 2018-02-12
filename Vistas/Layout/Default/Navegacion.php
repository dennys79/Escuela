<nav class="navbar-btn ui-corner-all">
    <?php if (isset($this->_barraHerramientas) AND is_array($this->_barraHerramientas)): ?>
        <div id="barraherramientas" class="container">
            <div id="toolbar" class="toolbar">
                <table class="toolbar">
                    <tbody>
                        <tr>
                            <?php for ($i = 0; $i < count($this->_barraHerramientas); $i++): ?>
                                <td id="toolbar" class="button">
                                    <a class="toolbar" onclick="<?php echo $this->_barraHerramientas[$i]['onclick']; ?>" href="<?php echo $this->_barraHerramientas[$i]['href']; ?>">
                                        <span class="<?php echo $this->_barraHerramientas[$i]['class']; ?>" title="<?php echo $this->_barraHerramientas[$i]['title']; ?>"></span><?php echo $this->_barraHerramientas[$i]['title']; ?></a>

                                    <?php if (!empty($this->_barraHerramientas[$i]['children'])): ?>
                                        <div class="dropdown-menu ui-state-default ui-corner-all">
                                            <?php foreach ($this->_barraHerramientas[$i]['children'] as $sub): ?>
                                                <a  href="<?php echo $sub['href']; ?>"><?php echo $sub['title']; ?></a>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                </td>

                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>    
        <?php
    elseif (isset($this->_barraHerramientas)):
        echo $this->_barraHerramientas;
    endif;
    ?>    
    
</nav>

    