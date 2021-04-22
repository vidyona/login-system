function $(e){return document.querySelector(e);}
function $All(e){return document.querySelectorAll(e);}

function extractJSON(s){
    return s.slice(
        s.search('{"'),
        s.search('"}') + 2
        );
}