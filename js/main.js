function extractJSON(s){
    var response = "", jsonText;
    
    if(jsonText = s.slice(s.search('{"'), s.search('"}') + 2)){
        response = JSON.parse(jsonText);
    }

    return response;
}

$(() => {
    const darkModeSwitch = $("#darkMode")[0];

    darkModeSwitch.checked = JSON.parse(localStorage.darkMode);
    
    darkModeHandler(darkModeSwitch);
    $("#darkMode").change(() => darkModeHandler(darkModeSwitch));
});

function darkModeHandler(darkModeSwitch){
    if(darkModeSwitch.checked) $("body").addClass("darkMode");
    else $("body").removeClass("darkMode");

    localStorage.darkMode = darkModeSwitch.checked;
}