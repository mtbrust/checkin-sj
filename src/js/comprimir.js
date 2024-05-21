// import Compress from "./compress.min.js";
// const compressor = new Compress();


const webCamElement = document.getElementById('webcam');
const canvasElement = document.getElementById('canvas');
const webcam = new Webcam(webCamElement, "user", canvasElement);

$(document).ready(function () {
    webcam.start();

    webCamElement
});

async function initCrop() {
    let picture = webcam.snap();
    const canvas = await crop(picture, 4 / 5);
    document.getElementById("foto").src = canvas.toDataURL();
}

function crop(url, aspectRatio) {

    // we return a Promise that gets resolved with our canvas element
    return new Promise(resolve => {

        // this image will hold our source image data
        const inputImage = new Image();

        // we want to wait for our image to load
        inputImage.onload = () => {

            // let's store the width and height of our image
            const inputWidth = inputImage.naturalWidth;
            const inputHeight = inputImage.naturalHeight;

            // get the aspect ratio of the input image
            const inputImageAspectRatio = inputWidth / inputHeight;

            // if it's bigger than our target aspect ratio
            let outputWidth = inputWidth;
            let outputHeight = inputHeight;
            if (inputImageAspectRatio > aspectRatio) {
                outputWidth = inputHeight * aspectRatio;
            } else if (inputImageAspectRatio < aspectRatio) {
                outputHeight = inputHeight / aspectRatio;
            }

            // calculate the position to draw the image at
            const outputX = (outputWidth - inputWidth) * .5;
            const outputY = (outputHeight - inputHeight) * .5;

            // create a canvas that will present the output image
            const outputImage = document.createElement('canvas');

            // set it to the same size as the image
            outputImage.width = outputWidth;
            outputImage.height = outputHeight;

            // draw our image at position 0, 0 on the canvas
            const ctx = outputImage.getContext('2d');
            ctx.drawImage(inputImage, outputX, outputY);
            resolve(outputImage);
        };

        // start loading our image
        inputImage.src = url;
    })

}


function downloadDivAsImage(id) {
    // Crie um elemento de imagem
    const image = document.createElement('img');

    const divToDownload = document.getElementById(id);

    // Converta a div em uma imagem usando o DOMtoImage
    domtoimage.toPng(divToDownload)
        .then(function (dataUrl) {
            // Defina o atributo 'src' da imagem
            image.src = dataUrl;

            // Crie um link para download
            const link = document.createElement('a');
            link.href = dataUrl;
            link.download = 'superimagem.png';

            // Anexe a imagem ao link
            link.appendChild(image);

            // Simule um clique no link para iniciar o download
            link.click();
        })
        .catch(function (error) {
            console.error('Erro ao converter a div em imagem:', error);
        });
}