
  if (
    !"mediaDevices" in navigator ||
    !"getUserMedia" in navigator.mediaDevices
  ) {
    alert("Camera API is not available in your browser");
  }else{

  // get page elements
  const video = document.querySelector("#video");
  const btnPlay = document.querySelector("#btnPlay");
  const btnPause = document.querySelector("#btnPause");
  const btnScreenshot = document.querySelector("#btnScreenshot");
  const btnChangeCamera = document.querySelector("#btnChangeCamera");
  let img = document.getElementById("screenshots");

  // video constraints
  const constraints = {
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
    },
  };

  // use front face camera
  let useFrontCamera = true;

  // current video stream
  let videoStream;

  // handle events
  // play
  btnPlay.addEventListener("click", function () {
    video.play();

    $(btnPlay).css({
      display: "none"
    });

    $(btnPause).css({
      display: "block"
    });
  });

  // pause
  btnPause.addEventListener("click", function () {
    video.pause();

    $(btnPlay).css({
      display: "block"
    });

    $(btnPause).css({
      display: "none"
    });
  });

  // take screenshots
  btnScreenshot.addEventListener("click", function () {
    funcScreenshot()
  });

  function funcScreenshot() {
    let canvas = document.createElement("canvas");

    // Obtém as dimensões em formato 4:5
    dimensoes = dimensiona(video.videoWidth, video.videoHeight, 4 / 5);

    ajustaCam(dimensoes);

    canvas.width = dimensoes.w;
    canvas.height = dimensoes.h;
    canvas.getContext("2d").drawImage(video, dimensoes.x, dimensoes.y);

    // exibe a imagem.
    img.src = canvas.toDataURL("image/png");
    printToFile(img);
  }

  // switch camera
  btnChangeCamera.addEventListener("click", function () {
    funcChangeCamera();
  });

  function funcChangeCamera() {
    useFrontCamera = !useFrontCamera;
    initializeCamera();
  }

  // stop video stream
  function stopVideoStream() {
    if (videoStream) {
      videoStream.getTracks().forEach((track) => {
        track.stop();
      });
    }
  }

  // initialize
  async function initializeCamera() {
    stopVideoStream();
    constraints.video.facingMode = useFrontCamera ? "user" : "environment";

    try {
      videoStream = await navigator.mediaDevices.getUserMedia(constraints);
      video.srcObject = videoStream;
      // Espera video carregar na tela para redimensionar.
      video.addEventListener("loadeddata", () => {
        if (video.readyState >= 4) {
          ajustaCam();
        }
      });
    } catch (err) {
      alert("Could not access the camera");
    }
  }

  function ajustaCam() {

    // video = document.querySelector("#video");

    // Obtém as dimensões em formato 4:5
    dimensoes = dimensiona(video.videoWidth, video.videoHeight, 4 / 5);

    // Ajusta exibição da camera.
    $(video).css({
      marginLeft: -100,
      width: dimensoes.x * -1
    });
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

  function printToFile(div) {
    html2canvas(div).then(function (canvas) {
      // Mandar a imagem via post aqui.
      //console.log(canvas.toDataURL("image/png"));
      console.log('Mandar a imagem via post aqui.')
    });
  }

  initializeCamera();

    // return;
  }