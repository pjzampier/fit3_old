<?php $userLogin = $_SESSION['userlogin']; ?>
<div id="banner">
    <a href="<?php echo HOST_SITE . 'view/home'; ?>">
        <div class="logo">
            <img src="../../image/logo_ok.png" width="" height="">
        </div>
    </a>

    <div class="menu_interno">
        <a href="../profile_training" class="padrao"><!--img src="../../image/geral.png"--> <br>Perfil</a>
    </div>

    <?php if ($userLogin['user_id'] == '1') : ?>
        <div class="menu_interno">
            <a href="../foods/" class="padrao"><!--img src="../../image/geral.png"--> <br>Alimentos</a>
        </div>
    <?php endif; ?>

    <div class="menu_interno">
        <a href="../diets/" class="padrao"><!--img src="../../image/geral.png"--> <br>Dieta</a>
    </div>

    <div class="menu_interno">
        <a href="../user" class="padrao"><!--img src="../../image/geral.png"--> <br>Configuração</a>
    </div>



    <a href="../../index.php?validate=logout" title="Sair do Sistema">
        <div class="sair">x</div>
    </a>

</div>

<hr class="linha">

<br><br><br>