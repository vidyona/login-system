function extractJSON(s){
    var response = "", jsonText;
    
    if(jsonText = s.slice(s.search('{"'), s.search('"}') + 2)){
        response = JSON.parse(jsonText);
    }

    return response;
}