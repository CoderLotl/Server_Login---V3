import { navigate } from 'svelte-routing';
import { DataAccessFetch } from "../services/DataAccessFetch.js";

let dataAccess = new DataAccessFetch();

export function Logout(event)
{
    event.preventDefault();

    (async ()=>
    {        
        let serverResponse = await dataAccess.postData('http://localhost:8000/logout');
        if(serverResponse == true)
        {
            navigate('/');
        }
        else
        {
            console.log(serverResponse);
        }
    })();
}