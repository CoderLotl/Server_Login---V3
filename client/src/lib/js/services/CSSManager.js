export class CSSManager
{
    ClearCSS()
    {
        let CSSContainer = document.getElementById('css-container');
        CSSContainer.innerHTML = '';
    }

    SetCSS(cssFile = null)
    {
        this.ClearCSS();
        console.log('clearing the css...')
        
        if(cssFile != null)
        {
            console.log('setting the css...');
            let CSSContainer = document.getElementById('css-container');
            let css = document.createElement('link');
            css.rel = 'stylesheet';
            css.type = 'text/css';
            css.href = 'client/src/lib/css/' + cssFile + '.css';
    
            CSSContainer.appendChild(css);
        }
    }
}