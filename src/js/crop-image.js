

async function capture() {
    return true;
    console.log("iniciou a captura.");
    const video = document.querySelector("#video");
    let img = document.getElementById("screenshots");
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

    // exibe a imagem.
    img.src = canvas.toDataURL("image/png");    
    printToFile(img);
}