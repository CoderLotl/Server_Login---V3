import { navigate } from 'svelte-routing';
import { DataAccessFetch } from "../services/DataAccessFetch.js";

let dataAccess = new DataAccessFetch();

export function Login(event) {
    event.preventDefault();

    const user = document.getElementById('user');    
    const password = document.getElementById('password');    
    const response = document.getElementById('response');
    
    let payload = { user: user.value, password: password.value };
    
    (async () =>
    {
        let serverResponse = await dataAccess.postData('http://localhost:8000/login', payload);
        if (serverResponse)
        {            
            let resp = await serverResponse.json();
            
            if(serverResponse.ok)
            {                
                let svResponse = JSON.parse(resp['response']);
                
                if (svResponse.hasOwnProperty('token')) {                
                    response.textContent = 'Token: ' + svResponse['token'];
                    console.log('Token: ' + svResponse['token']);
                    setTimeout(() => {                    
                        navigate('/home');
                    }, 1000);                
                }
            }
            else
            {
                response.textContent = 'Error: ' + resp['response'];
            }
        }
        else
        {
            let message = 'Error contacting the server.';
            console.log(serverResponse);
            response.textContent = message;
        }
    })();
}