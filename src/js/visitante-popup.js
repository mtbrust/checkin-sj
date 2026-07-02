(function() {
    function visitantePopupGarantirModal() {
        if (document.getElementById('modal-foto-visitante-preview-global')) {
            return;
        }

        const html = '' +
            '<div class="modal fade" id="modal-foto-visitante-preview-global" tabindex="-1" aria-labelledby="modalFotoVisitantePreviewGlobalLabel" aria-hidden="true">' +
            '  <div class="modal-dialog modal-dialog-centered">' +
            '    <div class="modal-content">' +
            '      <div class="modal-header py-2">' +
            '        <h2 class="modal-title h6 mb-0" id="modalFotoVisitantePreviewGlobalLabel">Foto do visitante</h2>' +
            '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>' +
            '      </div>' +
            '      <div class="modal-body text-center">' +
            '        <img src="" alt="Foto ampliada do visitante" id="visitante-popup-img-global" style="width:100%;max-width:420px;max-height:70vh;object-fit:contain;border-radius:8px;border:1px solid #e9ecef;">' +
            '      </div>' +
            '    </div>' +
            '  </div>' +
            '</div>';

        document.body.insertAdjacentHTML('beforeend', html);
    }

    function visitantePopupAbrir(idVisitante) {
        const id = parseInt(idVisitante, 10);
        if (!id) {
            return;
        }

        const dados = new FormData();
        dados.append('acao', 'foto');
        dados.append('id', String(id));

        const baseUrl = window.SITE_BASE_URL || '';
        ajaxDados(baseUrl + '?api=visitante', dados, function(ret) {
            if (!ret || !ret.ret || !ret.dados) {
                notificaErro((ret && ret.msg) ? ret.msg : 'Não foi possível carregar a foto.');
                return;
            }

            if (!ret.dados.fotoUrl) {
                notificaErro('Este visitante ainda não possui foto.');
                return;
            }

            visitantePopupGarantirModal();

            const modalEl = document.getElementById('modal-foto-visitante-preview-global');
            const modalTitle = document.getElementById('modalFotoVisitantePreviewGlobalLabel');
            const modalImg = document.getElementById('visitante-popup-img-global');
            if (!modalEl || !modalImg || typeof bootstrap === 'undefined') {
                return;
            }

            modalTitle.textContent = ret.dados.fullName || 'Foto do visitante';
            modalImg.src = ret.dados.fotoUrl;
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        });
    }

    window.visitantePopupAbrir = visitantePopupAbrir;

    document.addEventListener('click', function(event) {
        const btn = event.target.closest('.js-visitante-foto');
        if (!btn) {
            return;
        }

        event.preventDefault();
        const id = btn.getAttribute('data-visitante-id');
        visitantePopupAbrir(id);
    });
})();
