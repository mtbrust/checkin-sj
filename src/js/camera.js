const video = document.querySelector('#video');
let useFrontCamera = true;
let videoStream;
let constraintsCamera = {
    video: {
        width: {
            min: 1280,
            ideal: 1920,
            max: 2560,
        },
        height: {
            min: 720,
            ideal: 1080,
            max: 1440,
        },
        deviceId: { exact: '' }
    },
    audio: false,
}

function stopVideoStream() {
    if (videoStream) {
        videoStream.getTracks().forEach((track) => {
            track.stop();
        });
        
        videoStream.getTracks().forEach((video) => {
            video.stop();
        });
    }
}

async function ligarCamera(canSelected) {
    stopVideoStream();

    // Preciso dessa linha para testar no pc.
    constraintsCamera.video.facingMode = useFrontCamera ? "user" : "environment";
    constraintsCamera.video.deviceId = { exact: canSelected };

    try {
        // videoStream = await navigator.mediaDevices.getUserMedia(constraintsCamera);
        // video.srcObject = videoStream;

        navigator.mediaDevices
            .getUserMedia(constraintsCamera)
            .then(stream => {
                currentStream = stream;
                video.srcObject = stream;
                return navigator.mediaDevices.enumerateDevices();
            });
    } catch (err) {
        alert("Could not access the camera");
    }
}

// Lista na telas as câmeras que dispositivo tem.
function listarCameras(mediaDevices) {

    // Limpa lista de cameras.
    $('#cameras').html('');

    let count = 1;
    mediaDevices.forEach(mediaDevice => {
        if (mediaDevice.kind === 'videoinput' && mediaDevice.deviceId != '') {

            // Já abre a câmera back.
            if (mediaDevice.label.includes('back')) {
                ligarCamera(mediaDevice.deviceId);
            }

            // Mostra na tela as opções de cameras.
            link = '<a class="btn btn-sm btn-info m-1" onclick="ligarCamera(\'' + mediaDevice.deviceId + '\')"><i class="fas fa-camera"></i> ' + count++ + '</a>';
            $('#cameras').append(link);
        }
    });
}

// Chama a função listarCameras com as câmeras que o navegador encontrou.
function obterCameras() {
    navigator.mediaDevices.enumerateDevices().then(listarCameras);
}

// Realiza a conversão de uma tag em uma imagem.
function tirarFoto() {
    html2canvas($("#video")[0]).then((canvas) => {
        console.log('otimizada', canvas.toDataURL());
        imageSize(canvas.toDataURL());
        $("#img-out").prop('src', canvas.toDataURL());
        $("#f-fotoPerfil").val(canvas.toDataURL());
    });
    
    $("#video").stop();
}

function imageSize(base64) {
    fetch(base64).then(response => response.arrayBuffer()).then(buf => {
        console.log(buf.byteLength);
        $('#tamanho').text(buf.byteLength);
    });
}
