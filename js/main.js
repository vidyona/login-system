function extractJSON(s){
    var responses = [], jsonText, a;

    try {
        for(let j of s.split("{")){
            if(!j) continue;

            a = "{" + j;
    
            if(jsonText = a.slice(a.search('{"'), a.search('}') + 2)){
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

    $("#customForm input").last().focus(() => {
        $("input").last().keypress((event) => {
            if(event.which == 13){
                $("#submitButton").click();
            }
        });
    });
});

function darkModeHandler(darkModeSwitch){
    if(darkModeSwitch.checked) $("body").addClass("darkMode");
    else $("body").removeClass("darkMode");

    localStorage.darkMode = darkModeSwitch.checked;
}