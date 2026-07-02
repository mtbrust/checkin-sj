<?php

$bdLogins = new BdLogins();
$users = (array) $bdLogins->selectAll();
$sessionUser = Seguranca::getSession();

$bloco_logins_titulo = $bloco_logins_titulo ?? 'Entrar';
$bloco_logins_subtitulo = $bloco_logins_subtitulo ?? 'Clique na sua foto ou no seu nome para entrar. Não é necessário senha.';
$bloco_logins_redirect = $bloco_logins_redirect ?? (BASE_URL . '?page=home');

$users_html = '';

foreach ($users as $user) {
    $foto = MidiaUsuario::urlDoUsuario($user);

    $foto_html = '<img src="' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') . '" alt="" class="user-foto">';

    $ativo = ((int) $sessionUser['id'] === (int) $user['id']) ? ' user-card-active' : '';
    $primeiroNome = explode(' ', trim($user['fullName']))[0];

    $users_html .= '<div class="col-6 col-sm-4 col-md-3 col-lg-2">';
    $users_html .= '<button type="button" class="user-card' . $ativo . '" onclick="loginEquipe(' . (int) $user['id'] . ')" title="Entrar como ' . htmlspecialchars($user['fullName'], ENT_QUOTES, 'UTF-8') . '">';
    $users_html .= $foto_html;
    $users_html .= '<div class="user-nome">' . htmlspecialchars($primeiroNome, ENT_QUOTES, 'UTF-8') . '</div>';
    $users_html .= '<div class="user-nome-completo">' . htmlspecialchars($user['fullName'], ENT_QUOTES, 'UTF-8') . '</div>';
    if ($ativo) {
        $users_html .= '<span class="user-badge-ativo">Conectado</span>';
    } else {
        $users_html .= '<span class="user-badge-inativo">Desconectado</span>';
    }
    $users_html .= '</button>';
    $users_html .= '</div>';
}

?>

<div class="row">
    <div class="col-12">
        <h1><?php echo htmlspecialchars($bloco_logins_titulo, ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="text-muted mb-0"><?php echo htmlspecialchars($bloco_logins_subtitulo, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</div>

<div class="row mt-4 g-2">
    <?php
    if ($users_html) {
        echo $users_html;
    } else {
        echo '<div class="col-12"><p class="text-muted">Nenhum membro cadastrado ainda.</p></div>';
    }
    ?>
</div>

<?php if (!defined('BLOCO_LOGINS_ASSETS')): define('BLOCO_LOGINS_ASSETS', true); ?>

<style>
    .user-card {
        width: 100%;
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 14px 10px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        text-align: center;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
    }

    .user-card:hover,
    .user-card:focus {
        transform: translateY(-2px);
        border-color: #0d6efd;
        box-shadow: 0 6px 16px rgba(13, 110, 253, 0.18);
        outline: none;
    }

    .user-card-active {
        border-color: #198754;
        background: #f3faf6;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.15);
    }

    .user-foto {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: 50%;
        margin: 0 auto 10px;
        display: block;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px #dee2e6;
    }

    .user-card:hover .user-foto,
    .user-card:focus .user-foto {
        box-shadow: 0 0 0 2px #0d6efd;
    }

    .user-card-active .user-foto {
        box-shadow: 0 0 0 2px #198754;
    }

    .user-foto-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f3f5;
        color: #868e96;
        font-size: 28px;
    }

    .user-nome {
        font-size: 15px;
        font-weight: 700;
        color: #212529;
        line-height: 1.2;
        word-break: break-word;
    }

    .user-nome-completo {
        font-size: 11px;
        color: #868e96;
        margin-top: 4px;
        line-height: 1.2;
        word-break: break-word;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .user-badge-ativo,
    .user-badge-inativo {
        display: inline-block;
        margin-top: 8px;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .user-badge-ativo {
        background: #198754;
        color: #fff;
    }

    .user-badge-inativo {
        background: #e9ecef;
        color: #6c757d;
    }
</style>

<script>
    if (typeof loginEquipe !== 'function') {
        function loginEquipe(id) {
            const dados = new FormData();
            dados.append('acao', 'login');
            dados.append('id', id);

            $('.user-card').prop('disabled', true);

            ajaxDados('<?php echo BASE_URL . '?api=login'; ?>', dados, function(ret) {
                if (ret.ret && ret.dados) {
                    window.location.href = '<?php echo $bloco_logins_redirect; ?>';
                    return;
                }

                $('.user-card').prop('disabled', false);

                notificaErro(ret.msg || 'Não foi possível entrar.');
            });
        }
    }
</script>

<?php endif; ?>
