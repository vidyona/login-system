function extractJSON(s){
    var responses = [], jsonText, a;

    try {
        for(let j of s.split("{")){
            if(!j) continue;

            a = "{" + j;

            if(jsonText = a.slice(a.search('{"'), a.search('}') + 1)){
                responses.push(JSON.parse(jsonText));
            } else {console.log(j)};
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


    $("#customForm input[type='password']").last().keypress((event) => {
        if(event.which == 13){
            $("#submitButton").click();
        }
    });
});

function darkModeHandler(darkModeSwitch){
    if(darkModeSwitch.checked) $("body").addClass("darkMode");
    else $("body").removeClass("darkMode");

    localStorage.darkMode = darkModeSwitch.checked;
}

// function validate(fieldName){
//     const targetAlertDOM = $("." + fieldName + " > div");
//
//     var n = $("." + fieldName + " > input").val();
//
//     var inValPos = n.search(/[^a-zA-Z0-9-_.]/g);
//
//     if(inValPos >= 0){
//         targetAlertDOM.text("Only a-z A-Z 0-9 '-' '_' and '.' are allowed");
//         return false;
//     }
//
//     targetAlertDOM.text("");
//
//     return true;
// }

function responseHandler(data, status){
    console.log({status: status, data: data});

    var responses = extractJSON(data);

    for(let response of responses){
        if(typeof response == "object" && response.message){
            messageHandler(response);
        }
    }
}
