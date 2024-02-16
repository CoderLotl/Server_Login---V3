import { DataAccessFetch } from "../services/DataAccessFetch";
let DataAccess = new DataAccessFetch();
const currentPath = window.location.pathname;
const parts = currentPath.split('/');
const code = parts[parts.length - 1]

export async function Verify()
{
    let vContent = document.getElementById('verify-content');
    let content = document.createElement('p');
    vContent.appendChild(content);
    
    if(code.length != 10)
    {
        content.textContent = 'Nope';
    }
    else
    {
        let response = await DataAccess.postData('http://localhost:8000/verify_account', {code: code});
        if(response)
        {
            let resp = await response.json();

            if(response.ok)
            {                
                content.textContent = resp['response'];                
            }
            else
            {
                content.textContent = 'Error: ' + resp['response'];
            }
        }
        else
        {
            let message = 'Error contacting the server.';
            console.log(serverResponse);
            content.textContent = message;
        }
    }
}