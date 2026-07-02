<form action="<?php echo BASE_URL . '?api=equipe'; ?>" class="row" id="form_equipe" name="form_equipe" method="post" enctype="multipart/form-data" onsubmit="return enviarEquipe(event);">
    <div class="col-sm-6">
        <div class="mb-3">
            <label for="f-cpf" class="form-label">CPF</label>
            <input type="text" class="form-control cpf" id="f-cpf" name="f-cpf" placeholder="000.000.000-00">
            <div class="form-text">Cadastre-se aqui se ainda não aparecer na lista acima.</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="mb-3">
            <label for="f-fullName" class="form-label">Nome completo</label>
            <input type="text" class="form-control" id="f-fullName" name="f-fullName" style="text-transform: uppercase;">
            <div class="form-text">Obrigatório apenas para novo cadastro.</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="mb-3">
            <label for="f-telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control phone" id="f-telefone" name="f-telefone" placeholder="(00) 00000-0000">
            <div class="form-text">Obrigatório apenas para novo cadastro.</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="mb-3">
            <label for="f-foto" class="form-label">Foto de perfil</label>
            <input type="file" class="form-control" id="f-foto" name="f-foto" accept="image/*">
            <div class="form-text">Imagem redimensionada automaticamente para economizar espaço.</div>
        </div>
    </div>
    <div class="col-12 mb-3 text-center">
        <img src="" id="img-equipe-preview" alt="Prévia da foto" class="d-none" style="width: 96px; height: 96px; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6;">
        <div id="foto-equipe-tamanho" class="form-text d-none"></div>
    </div>
    <div class="col-12">
        <div class="mb-3 text-end">
            <button type="submit" class="btn btn-primary mb-3" id="btn_equipe_entrar">CADASTRAR E ENTRAR</button>
        </div>
    </div>
</form>

<script>
    const FOTO_EQUIPE_MAX = 120;
    const FOTO_EQUIPE_QUALIDADE = 0.7;
    let fotoEquipeArquivo = null;

    $('#f-foto').on('change', function() {
        const arquivo = this.files[0];
        if (!arquivo) {
            fotoEquipeArquivo = null;
            return;
        }

        if (!arquivo.type.startsWith('image/')) {
            notificaErro('Selecione uma imagem.', 'Arquivo inválido.');
            this.value = '';
            fotoEquipeArquivo = null;
            return;
        }

        comprimirFotoEquipe(arquivo).catch(function() {
            notificaErro('Não foi possível processar a imagem.');
        });
    });

    function comprimirFotoEquipe(arquivo) {
        return new Promise(function(resolve, reject) {
            const leitor = new FileReader();

            leitor.onerror = function() {
                reject();
            };

            leitor.onload = function(evento) {
                const imagem = new Image();

                imagem.onerror = function() {
                    reject();
                };

                imagem.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    let largura = imagem.width;
                    let altura = imagem.height;

                    if (largura > altura) {
                        if (largura > FOTO_EQUIPE_MAX) {
                            altura = Math.round(altura * (FOTO_EQUIPE_MAX / largura));
                            largura = FOTO_EQUIPE_MAX;
                        }
                    } else if (altura > FOTO_EQUIPE_MAX) {
                        largura = Math.round(largura * (FOTO_EQUIPE_MAX / altura));
                        altura = FOTO_EQUIPE_MAX;
                    }

                    canvas.width = largura;
                    canvas.height = altura;
                    ctx.drawImage(imagem, 0, 0, largura, altura);

                    canvas.toBlob(function(blob) {
                        if (!blob) {
                            reject();
                            return;
                        }

                        fotoEquipeArquivo = blob;
                        $('#img-equipe-preview').prop('src', URL.createObjectURL(blob)).removeClass('d-none');
                        $('#foto-equipe-tamanho').removeClass('d-none').text('Tamanho aproximado: ' + Math.round(blob.size / 1024) + ' KB');
                        resolve(blob);
                    }, 'image/jpeg', FOTO_EQUIPE_QUALIDADE);
                };

                imagem.src = evento.target.result;
            };

            leitor.readAsDataURL(arquivo);
        });
    }

    async function enviarEquipe(evento) {
        evento.preventDefault();

        const fileInput = document.getElementById('f-foto');

        if (fileInput.files[0] && !fotoEquipeArquivo) {
            $('#btn_equipe_entrar').text('Aguarde...');
            $('#btn_equipe_entrar').prop('disabled', true);

            try {
                await comprimirFotoEquipe(fileInput.files[0]);
            } catch (e) {
                notificaErro('Não foi possível processar a imagem.');
                $('#btn_equipe_entrar').text('CADASTRAR E ENTRAR');
                $('#btn_equipe_entrar').prop('disabled', false);
                return false;
            }
        }

        const dados = new FormData();
        dados.append('f-cpf', $('#f-cpf').val());
        dados.append('f-fullName', $('#f-fullName').val());
        dados.append('f-telefone', $('#f-telefone').val());

        if (fotoEquipeArquivo) {
            dados.append('f-foto', fotoEquipeArquivo, 'perfil.jpg');
        }

        $('#btn_equipe_entrar').text('Aguarde...');
        $('#btn_equipe_entrar').prop('disabled', true);

        ajaxDados('<?php echo BASE_URL . '?api=equipe'; ?>', dados, function(ret) {
            if (ret.ret) {
                window.location.href = '<?php echo BASE_URL . '?page=home'; ?>';
                return;
            }

            notificaErro(ret.msg || 'Não foi possível entrar.');

            $('#btn_equipe_entrar').text('CADASTRAR E ENTRAR');
            $('#btn_equipe_entrar').prop('disabled', false);
        });

        return false;
    }
</script>
