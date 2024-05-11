function getParameterFromURL(parameterName) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(parameterName);
}

document.addEventListener('DOMContentLoaded', function() {
    const ele = document.getElementsByClassName('selection-wrap');
    if(getParameterFromURL("type")==="SM"){
        ele[0].style.display = 'none';
    }else if(getParameterFromURL("type")==="D"){
        ele[1].style.display = 'none';
    }
})