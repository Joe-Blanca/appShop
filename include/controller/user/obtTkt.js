function apTk(id, email) {
    const apiUrl = '/bit/bitApp/include/model/user/tkt.php';

    const requestData = {
        id: id,
        email: email
    };
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        const token = data.token;
        tktSession(token);
    })
    .catch(error => {
        console.error('Erro ao fazer a chamada de API:', error);
    });
}


    function tktSession(token) {
        const xhr = new XMLHttpRequest();
    
        const serverUrl = '/bit/bitApp/include/model/user/armTkt.php';
    
        xhr.open('POST', serverUrl, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
        const data = 'token=' + token;
    
        xhr.send(data);
    
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    console.log('ok', xhr.statusText);
                } else {
                    console.error('Erro tkt', xhr.statusText);
                }
            }
        };
    }