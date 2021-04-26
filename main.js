function extractJSON(s){
    return s.slice(
        s.search('{"'),
        s.search('"}') + 2
        );
}