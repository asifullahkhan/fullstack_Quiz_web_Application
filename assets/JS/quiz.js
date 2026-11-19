let totalSeconds = 20 * 60;

const timer = setInterval(function(){

    let minutes = Math.floor(totalSeconds/60);

    let seconds = totalSeconds%60;

    document.getElementById("quizTimer").innerHTML =
        minutes + ":" + String(seconds).padStart(2,'0');

    totalSeconds--;

    if(totalSeconds < 0){

        clearInterval(timer);

        alert("Time is over!");

        document.getElementById("quizForm").submit();

    }

},1000);