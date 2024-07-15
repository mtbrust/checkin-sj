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
    let count = 1;
    mediaDevices.forEach(mediaDevice => {
        if (mediaDevice.kind === 'videoinput' && mediaDevice.deviceId != '') {

            // Já abre a câmera back.
            if (mediaDevice.label.includes('back')) {
                ligarCamera(mediaDevice.deviceId);
            }

            // Mostra na tela as opções de cameras.
            link = '<a href="#" onclick="ligarCamera(\'' + mediaDevice.deviceId + '\')">Camera ' + count++ + '</a>';
            $('#cameras').append(link);
        }
    });
}

function obterCameras() {
    navigator.mediaDevices.enumerateDevices().then(listarCameras);
}

function funcScreenshot() {

    let canvas = document.createElement("canvas");

    // Obtém as dimensões em formato 4:5
    // dimensoes = dimensiona(video.videoWidth, video.videoHeight, 4 / 5);
    // canvas.width = dimensoes.w;
    // canvas.height = dimensoes.h;
    // canvas.getContext("2d").drawImage(video, dimensoes.x, dimensoes.y);


    canvas.getContext("2d").drawImage(video, video.videoWidth, video.videoHeight);

    // exibe a imagem.
    imageBase64 = canvas.toDataURL("image/png");
    console.log(imageBase64);
    $('#img').prop('src', imageBase64);

    // reduz o tamanho.
    divToPng();
}

function dimensiona(w, h, aspectRatio = 4 / 5) {

    // get the aspect ratio of the input image
    const inputImageAspectRatio = w / h;

    // if it's bigger than our target aspect ratio
    let outputWidth = w;
    let outputHeight = h;
    if (inputImageAspectRatio > aspectRatio) {
        outputWidth = h * aspectRatio;
    } else if (inputImageAspectRatio < aspectRatio) {
        outputHeight = h / aspectRatio;
    }

    // calculate the position to draw the image at
    const outputX = (outputWidth - w) * .5;
    const outputY = (outputHeight - h) * .5;

    return {
        x: outputX,
        y: outputY,
        w: outputWidth,
        h: outputHeight
    };
}

function divToPng() {
    html2canvas($("#img")[0]).then((canvas) => {
        console.log(canvas.toDataURL());
        imageSize(canvas.toDataURL());
        $("#img-out").prop('src', canvas.toDataURL());
    });
}

function imageSize(base64) {
    fetch(base64).then(response => response.arrayBuffer()).then(buf => {
        console.log(buf.byteLength);
        $('#tamanho').text(buf.byteLength);
    });
}
