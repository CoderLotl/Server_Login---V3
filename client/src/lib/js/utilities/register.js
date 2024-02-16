import { DataAccessFetch } from "../services/DataAccessFetch.js";

let dataAccess = new DataAccessFetch();

export function Register(event)
{
    event.preventDefault();

    let user = document.getElementById('user');    
    let mail = document.getElementById('mail');
    let password = document.getElementById('password'); 
    let response = document.getElementById('r-resp-msg');
    
    let payload = { user: user.value, password: password.value, mail: mail.value };

    let respImg = document.getElementById('r-resp-img');
    respImg.className = '';
    response.innerHTML = '';
    response.textContent = '';

    if(ValidateFields(user.value, mail.value, password.value, response))
    {
        (async () =>
        {
            let serverResponse = await dataAccess.postData('http://localhost:8000/register/submit', payload);
            
            if(serverResponse)
            {                
                let resp = await serverResponse.json();
                    
                if(serverResponse.ok)
                {
                    response.textContent = resp['response'];
                    respImg.classList.add('goodLotl');
                }
                else
                {
                    response.textContent = 'Error: ' + resp['response'];
                    respImg.classList.add('badLotl');
                }
            }
            else
            {                
                response.textContent = 'Error contacting the server.';;
                respImg.classList.add('networkError');
            }
        })();
    }
    else
    {
        respImg.classList.add('badLotl');
    }
}

function ValidateFields(user, mail, password, response)
{
    let errors = [];
    errors.push(ValidateUsername(user));
    errors.push(ValidateEmail(mail));
    errors.push(ValidatePassword(password));

    response.innerHTML = '';
    let errorList = document.createElement('ul');
    response.appendChild(errorList);

    if(errors[0] === false)
    {
        errorList.appendChild(document.createElement('li')).textContent = 'Error: username must have 4 or more characters and at least 1 letter.';
    }
    if(errors[1] === false)
    {
        errorList.appendChild(document.createElement('li')).textContent = 'Error: email address is not valid.';
    }
    if(errors[2] === false)
    {
        errorList.appendChild(document.createElement('li')).textContent = "Error: password can't be blank nor only white spaces.";
    }

    return errors.every(error => error);
}

function ValidateEmail(value)
{
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value);
}

function ValidateUsername(value)
{ 
    return value.length >= 4 && /[A-Za-z]/.test(value) && /^[A-Za-z0-9]+$/.test(value);
}

function ValidatePassword(value) {
    return value.length >= 6 && /\S/.test(value);
}