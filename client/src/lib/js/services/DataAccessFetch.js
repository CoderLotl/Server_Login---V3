
export class DataAccessFetch
{
    // GET
    async getData(url)
    {
        try {
            const response = await fetch(url,
            {
                method: 'GET',
                headers:
                {
                    'Content-Type': 'application/json'
                }
            });            

            if(response.ok)
            {
                return response.json();                
            }
            else
            {
                return false;
            }
        }
        catch (error)
        {
            console.error('Error fetching data:');
            throw error;
        }
    }
    
    // POST
    async postData(url, payload = null)
    {
        try{
            let response;
            let payL = payload !== null ? JSON.stringify(payload) : '';
    
            response = await fetch(url,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: payL,
                credentials: 'include'
            });
    
            if(response)
            {
                if(payload == null)
                {
                    return true;
                }
                else
                {
                    return response;
                }
            }
            else
            {
                return false; // or handle the error as needed
            }
        }
        catch (error)
        {
            console.error('Error posting data:', error);
            throw error;
        }
    }

    // PUT
    async putData(url, payload)
    {
        try {
            const response = await fetch(url,
            {
                method: 'PUT',
                headers:
                {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            if(response)
            {
                return response;
            }
            else
            {
                return false;
            }
        }
        catch (error)
        {
            console.error('Error updating data:', error);
            throw error;
        }
    }
    
    // DELETE
    async deleteData(url, id)
    {
        try {
            const response = await fetch(url + "/" + id,
            {
                method: 'DELETE',
                headers:
                {
                    'Content-Type': 'application/json'
                }
            });
            return `${response.status}: ${response.statusText}`;            
        }
        catch (error)
        {
            console.error('Error deleting data:', error);
            throw error;
        }
    }
}