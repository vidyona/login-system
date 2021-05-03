function extractJSON(s){
    var responses = [], jsonText, a;

    try {
        for(let j of s.split("{")){
            if(!j) continue;

            a = "{" + j;
    
            if(jsonText = a.slice(a.search('{"'), a.search('"}') + 2)){
                responses.push(JSON.parse(jsonText));
            }
        }
    } catch (error) {
        console.log(error);
    }

    return responses;
}

$(() => {
    const darkModeSwitch = $("#darkMode")[0];

    if(localStorage.darkMode){
        darkModeSwitch.checked = JSON.parse(localStorage.darkMode);
    }
    
    darkModeHandler(darkModeSwitch);
    $("#darkMode").change(() => darkModeHandler(darkModeSwitch));
});

function darkModeHandler(darkModeSwitch){
    if(darkModeSwitch.checked) $("body").addClass("darkMode");
    else $("body").removeClass("darkMode");

    localStorage.darkMode = darkModeSwitch.checked;
}