(function() {
    const FOTO_MAX = 320;
    const FOTO_QUALIDADE = 0.72;

    let fotoStream = null;
    let fotoFrontal = false;
    let fotoModal = null;
    let fotoPreviewModal = null;

    function fotoEl(id) {
        return document.getElementById(id);
    }

    function fotoPararCamera() {
        if (!fotoStream) {
            return;
        }

        fotoStream.getTracks().forEach(function(track) {
            track.stop();
        });
        fotoStream = null;

        const video = fotoEl('visitante-foto-video');
        if (video) {
            video.srcObject = null;
        }
    }

    async function fotoIniciarCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            throw new Error('Câmera não disponível neste dispositivo.');
        }

        fotoPararCamera();

        const constraints = {
            audio: false,
            video: {
                facingMode: fotoFrontal ? 'user' : 'environment',
                width: { ideal: 1280, max: 1920 },
                height: { ideal: 720, max: 1080 }
            }
        };

        fotoStream = await navigator.mediaDevices.getUserMedia(constraints);
        const video = fotoEl('visitante-foto-video');
        video.srcObject = fotoStream;
        await video.play();
    }

    function fotoRedimensionar(video, canvas) {
        let largura = video.videoWidth || 320;
        let altura = video.videoHeight || 240;

        if (largura > altura) {
            if (largura > FOTO_MAX) {
                altura = Math.round(altura * (FOTO_MAX / largura));
                largura = FOTO_MAX;
            }
        } else if (altura > FOTO_MAX) {
            largura = Math.round(largura * (FOTO_MAX / altura));
            altura = FOTO_MAX;
        }

        canvas.width = largura;
        canvas.height = altura;

        const ctx = canvas.getContext('2d');
        ctx.imageSmoothingEnabled = true;
        ctx.imageSmoothingQuality = 'high';
        ctx.drawImage(video, 0, 0, largura, altura);
    }

    function fotoCapturar() {
        const video = fotoEl('visitante-foto-video');
        const canvas = document.createElement('canvas');

        fotoRedimensionar(video, canvas);

        return new Promise(function(resolve, reject) {
            canvas.toBlob(function(blob) {
                if (!blob) {
                    reject(new Error('Não foi possível capturar a foto.'));
                    return;
                }

                const leitor = new FileReader();
                leitor.onload = function() {
                    resolve({
                        dataUrl: leitor.result,
                        tamanho: blob.size
                    });
                };
                leitor.onerror = function() {
                    reject(new Error('Não foi possível processar a foto.'));
                };
                leitor.readAsDataURL(blob);
            }, 'image/jpeg', FOTO_QUALIDADE);
        });
    }

    function fotoAtualizarPreview(dataUrl, tamanho) {
        const campo = fotoEl('f-fotoPerfil');
        const preview = fotoEl('visitante-foto-preview');
        const info = fotoEl('visitante-foto-info');

        if (campo) {
            campo.value = dataUrl;
        }

        if (preview) {
            preview.src = dataUrl;
            preview.classList.remove('d-none');
        }

        if (info) {
            info.textContent = 'Foto pronta (' + Math.max(1, Math.round(tamanho / 1024)) + ' KB)';
            info.classList.remove('d-none');
        }
    }

    function fotoFecharModal() {
        fotoPararCamera();

        if (fotoModal) {
            fotoModal.hide();
        }
    }

    function fotoAbrirPreview() {
        const preview = fotoEl('visitante-foto-preview');
        const modalEl = fotoEl('modal-foto-visitante-preview');
        const modalImg = fotoEl('visitante-foto-preview-modal-img');

        if (!preview || !modalEl || !modalImg || preview.classList.contains('d-none') || !preview.src) {
            return;
        }

        if (typeof bootstrap === 'undefined') {
            return;
        }

        if (!fotoPreviewModal) {
            fotoPreviewModal = new bootstrap.Modal(modalEl);
        }

        modalImg.src = preview.src;
        fotoPreviewModal.show();
    }

    async function fotoAbrirModal() {
        const modalEl = fotoEl('modal-foto-visitante');
        if (!modalEl || typeof bootstrap === 'undefined') {
            alert('Não foi possível abrir a câmera.');
            return;
        }

        if (!fotoModal) {
            fotoModal = new bootstrap.Modal(modalEl);
        }

        fotoModal.show();

        try {
            await fotoIniciarCamera();
        } catch (err) {
            fotoFecharModal();
            if (typeof notificaErro === 'function') {
                notificaErro(err.message || 'Não foi possível acessar a câmera.');
            } else {
                alert(err.message || 'Não foi possível acessar a câmera.');
            }
        }
    }

    function fotoIniciarEventos() {
        const modalEl = fotoEl('modal-foto-visitante');
        const btnAbrir = fotoEl('btn_foto_visitante');
        const btnCapturar = fotoEl('btn-foto-capturar');
        const btnTrocar = fotoEl('btn-foto-trocar');
        const btnCancelar = fotoEl('btn-foto-cancelar');
        const preview = fotoEl('visitante-foto-preview');

        if (btnAbrir) {
            btnAbrir.addEventListener('click', fotoAbrirModal);
        }

        if (btnCapturar) {
            btnCapturar.addEventListener('click', function() {
                fotoCapturar()
                    .then(function(resultado) {
                        fotoAtualizarPreview(resultado.dataUrl, resultado.tamanho);
                        fotoFecharModal();

                        if (typeof notificaSucesso === 'function') {
                            notificaSucesso('Foto capturada. Salve o cadastro para gravar.');
                        }
                    })
                    .catch(function(err) {
                        if (typeof notificaErro === 'function') {
                            notificaErro(err.message || 'Não foi possível capturar a foto.');
                        } else {
                            alert(err.message || 'Não foi possível capturar a foto.');
                        }
                    });
            });
        }

        if (btnTrocar) {
            btnTrocar.addEventListener('click', function() {
                fotoFrontal = !fotoFrontal;
                fotoIniciarCamera().catch(function(err) {
                    if (typeof notificaErro === 'function') {
                        notificaErro(err.message || 'Não foi possível trocar a câmera.');
                    }
                });
            });
        }

        if (btnCancelar) {
            btnCancelar.addEventListener('click', fotoFecharModal);
        }

        if (preview) {
            preview.addEventListener('click', fotoAbrirPreview);
        }

        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', fotoPararCamera);
        }
    }

    window.visitanteFotoLimpar = function() {
        const campo = fotoEl('f-fotoPerfil');
        const preview = fotoEl('visitante-foto-preview');
        const info = fotoEl('visitante-foto-info');

        if (campo) {
            campo.value = '';
        }

        if (preview) {
            preview.src = '';
            preview.classList.add('d-none');
        }

        if (info) {
            info.textContent = '';
            info.classList.add('d-none');
        }

        fotoPararCamera();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fotoIniciarEventos);
    } else {
        fotoIniciarEventos();
    }
})();
