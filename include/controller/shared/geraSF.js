document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.geraSF').addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        formData.forEach(function(value, key){
            console.log(key + ': ' + value);
        });

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/bit/bitApp/include/model/gerarSF.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send(formData);
    });
});
