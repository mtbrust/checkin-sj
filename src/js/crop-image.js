

async function capture() {
    console.log("iniciou a captura.");
    const video = document.querySelector("#video");
    const img = document.getElementById("screenshots");
    const canvas = document.createElement("canvas");

    // Obtém as dimensões em formato 4:5
    dimensoes = dimensiona(video.videoWidth, video.videoHeight, 4/5);
    console.log(dimensoes);

    dimensoesPreview = dimensiona(dimensoes.w, dimensoes.h, 200);
    console.log(dimensoesPreview);
    $(video).css({
        marginLeft: -100,
        width: dimensoes.x * -1
    });

    canvas.width = dimensoes.w;
    canvas.height = dimensoes.h;
    canvas.getContext("2d").drawImage(video, dimensoes.x, dimensoes.y);
    
    printToFile(document.querySelector(".boxvideo"));

    // exibe a imagem.
    img.src = canvas.toDataURL("image/png");
}

function dimensiona(w, h, aspectRatio = 4/5) {

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

function printToFile(div) {
    html2canvas(div, {
        onrendered: function (canvas) {
            var myImage = canvas.toDataURL("image/png");
            //create your own dialog with warning before saving file
            //beforeDownloadReadMessage();
            //Then download file
            downloadURI("data:" + myImage, "yourImage.png");
        }
    });
}

function downloadURI(uri, name) {
    var link = document.createElement("a");
    link.download = name;
    link.href = uri;
    link.click();
    //after creating link you should delete dynamic link
    //clearDynamicLink(link); 
}